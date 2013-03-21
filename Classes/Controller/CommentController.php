<?php
namespace TYPO3\CommentsBase\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Allmer <d4kmor@gmail.com>, moodley brand identity
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package comments_base
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CommentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\CommentsBase\Domain\Repository\CommentRepository
	 * @inject
	 */
	protected $commentRepository;

	/**
	 * @var \TYPO3\CommentsBase\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $frontendUserRepository;

	/**
	 * @var \TYPO3\CommentsBase\Domain\Model\FrontendUser
	 */
	protected $frontendUser;

	/**
	 * @var string
	 */
	protected $entryId;

	/**
	 * @var \TYPO3\CMS\Core\Mail\MailMessage
	 * @inject
	 */
	protected $mailMessage;

	/**
	 * @var array
	 */
	protected $embedCache;

	/**
	 * 1. build entryId for the comment so we know what to query
	 * 2. check for a logged in user
	 * 3. set query settings so it will find hidden comments
	 */
	public function initializeAction() {
		$this->entryId = 'page::' . $GLOBALS['TSFE']->id;
		$entryIdArray = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP($this->settings['entryIdArray']); ;
		if (is_array($entryIdArray)) {
			$this->entryId = $this->settings['entryIdArray'] . '::' . $this->settings['entryIdValue'] . '::' . $entryIdArray[$this->settings['entryIdValue']];
		}
		$this->frontendUser = $GLOBALS['TSFE']->loginUser > 0 ? $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']) : NULL;

		$querySettings = $this->commentRepository->createQuery()->getQuerySettings();
		$querySettings->setIgnoreEnableFields(TRUE);
		$querySettings->setEnableFieldsToBeIgnored(array('disabled'));
		$this->commentRepository->setDefaultQuerySettings($querySettings);
	}

	/**
	 * @return void
	 */
	public function listAction() {
		$comments = $this->commentRepository->findRootCommentsByEntryId($this->entryId)->toArray();
		if ($this->frontendUser && !$this->frontendUser->hasRole('Administrator')) {
			foreach($comments as $key => &$comment) {
				if ($comment->getDisabled() === TRUE && $comment->getAuthor() !== $this->frontendUser) {
					unset($comments[$key]);
				}
			}
		}
		$this->view->assign('comments', $comments);
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $newComment
	 * @dontvalidate $newComment
	 * @return void
	 */
	public function newAction(\TYPO3\CommentsBase\Domain\Model\Comment $newComment = NULL) {
		$this->view->assign('newComment', $newComment);
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $newComment
	 * @return void
	 */
	public function createAction(\TYPO3\CommentsBase\Domain\Model\Comment $newComment) {
		$newComment->setEntryId($this->entryId);
		if ($this->frontendUser !== NULL) {
			$newComment->setAuthor($this->frontendUser);
		}
		$uri = $this->controllerContext->getUriBuilder()->reset()->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array('tx_commentsbase_new'))->build();
		$newComment->setUri($uri);
		if ($this->settings['requireApproval'] && !$this->frontendUser->hasRole('Administrator')) {
			$newComment->setDisabled(TRUE);
			$this->sendEmailsFor($newComment, 'onCreate');
		}
		$this->commentRepository->add($newComment);
		$this->redirectToUri($uri);
	}

	/**
	 * we need to manually check for the comment as it's currently hidden so it won't be found automatically
	 */
	public function initializeEnableAction() {
		if ($this->request->hasArgument('comment')) {
			$commentId = $this->request->getArgument('comment');
			$comment = $this->commentRepository->findByUid($commentId);
			$this->request->setArgument('comment', $comment);
		}
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @dontvalidate $comment
	 * @return void
	 */
	public function enableAction(\TYPO3\CommentsBase\Domain\Model\Comment $comment = NULL) {
		if ($this->frontendUser && $this->frontendUser->hasRole('Administrator')) {
			$comment->setDisabled(FALSE);
			$this->commentRepository->update($comment);
		}
		$this->redirectToUri($this->controllerContext->getUriBuilder()->reset()->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array('tx_commentsbase_list'))->build());
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @return void
	 */
	public function disableAction(\TYPO3\CommentsBase\Domain\Model\Comment $comment) {
		if ($this->frontendUser && $this->frontendUser->hasRole('Administrator')) {
			$comment->setDisabled(TRUE);
			$this->commentRepository->update($comment);
		}
		$this->redirectToUri($this->controllerContext->getUriBuilder()->reset()->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array('tx_commentsbase_list'))->build());
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @return void
	 */
	public function deleteAction(\TYPO3\CommentsBase\Domain\Model\Comment $comment) {
		if ($this->frontendUser && $this->frontendUser->hasRole('Administrator')) {
			$this->commentRepository->remove($comment);
		}
		$this->redirectToUri($this->controllerContext->getUriBuilder()->reset()->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array('tx_commentsbase_list'))->build());
	}

	/**
	 * @param $name
	 * @return object
	 */
	public function getEmailView($name) {
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
		$emailView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
		$emailView->setTemplatePathAndFilename($templateRootPath . 'Email/' . $name . '.html');
		$emailView->assign('templateRootPath', $templateRootPath);
		$emailView->assign('settings', $this->settings);
		return $emailView;
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @param $for
	 */
	public function sendEmailsFor(\TYPO3\CommentsBase\Domain\Model\Comment $comment, $for) {
		if (is_array($this->settings[$for])) {
			foreach($this->settings[$for] as $template => $mailSettings) {
				$emailView = $this->getEmailView($template);
				$emailView->assign('comment', $comment);
				$body = $emailView->render();

				foreach(array('fromEmail', 'fromName', 'toEmail', 'toName') as $property) {
					if (strpos($mailSettings[$property], 'Function:') !== FALSE) {
						$function = substr($mailSettings[$property], 9);
						$mailSettings[$property] = $comment->getAuthor()->$function();
					}
				}
				$mailSettings['subject'] = sprintf($mailSettings['subject'], $comment->getAuthor()->getName(), $comment->getAuthor()->getEmail(), $comment->getAuthor()->getUsername());

				$this->mailMessage->setFrom(array($mailSettings['fromEmail'] => $mailSettings['fromName']));
				$this->mailMessage->setTo(array($mailSettings['toEmail'] => $mailSettings['toName']));
				$this->mailMessage->setSubject($mailSettings['subject']);

				$body = preg_replace_callback('/(<img [^>]*src=["|\'])([^"|\']+)/i', array(&$this, 'imageEmbed'), $body);
				$this->mailMessage->setBody($body, 'text/html');
				$this->mailMessage->send();
			}
		}
	}

	/**
	 * @param $match
	 * @return string
	 */
	private function imageEmbed($match) {
		if ($this->embedCache === NULL) {
			$this->embedCache = array();
		}
		$key = $match[2];
		if (array_key_exists($key, $this->embedCache)) {
			return $match[1] . $this->embedCache[$key];
		}
		$this->embedCache[$key] = $this->mailMessage->embed(\Swift_Image::fromPath($match[2]));

		return $match[1] . $this->embedCache[$key];
	}

}
?>