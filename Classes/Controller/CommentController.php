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
	 *
	 */
	public function initializeAction() {
		$this->entryId = '';
		$entryIdArray = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP($this->settings['entryIdArray']); ;
		if (is_array($entryIdArray)) {
			$this->entryId = $this->settings['entryIdArray'] . '::' . $this->settings['entryIdValue'] . '::' . $entryIdArray[$this->settings['entryIdValue']];
		}
		$this->frontendUser = $GLOBALS['TSFE']->loginUser > 0 ? $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']) : NULL;

		$querySettings = $this->commentRepository->createQuery()->getQuerySettings();
		$querySettings->setIgnoreEnableFields(TRUE);
		$querySettings->setEnableFieldsToBeIgnored(array('disabled'));
		$this->commentRepository->setDefaultQuerySettings($querySettings);

		if ($this->request->hasArgument('comment')) {
			$commentId = $this->request->getArgument('comment');
			$comment = $this->commentRepository->findByUid($commentId);
			$this->request->setArgument('comment', $comment);
		}
	}

	/**
	 * @return void
	 */
	public function listAction() {
		$comments = $this->commentRepository->findByEntryId($this->entryId)->toArray();
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
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $ncomment
	 * @dontvalidate $comment
	 * @return void
	 */
	public function newAction(\TYPO3\CommentsBase\Domain\Model\Comment $comment = NULL) {
		$this->view->assign('comment', $comment);
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @return void
	 */
	public function createAction(\TYPO3\CommentsBase\Domain\Model\Comment $comment) {
		$comment->setEntryId($this->entryId);
		if ($this->frontendUser !== NULL) {
			$comment->setAuthor($this->frontendUser);
		}
		$this->commentRepository->add($comment);
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$newUri = $uriBuilder->reset()->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array('tx_commentsbase_new'))->build();
		$this->redirectToUri($newUri);
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
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$newUri = $uriBuilder->reset()->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array('tx_commentsbase_list'))->build();
		$this->redirectToUri($newUri);
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
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$newUri = $uriBuilder->reset()->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array('tx_commentsbase_list'))->build();
		$this->redirectToUri($newUri);
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @return void
	 */
	public function deleteAction(\TYPO3\CommentsBase\Domain\Model\Comment $comment) {
		if ($this->frontendUser && $this->frontendUser->hasRole('Administrator')) {
			$this->commentRepository->remove($comment);
		}
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$newUri = $uriBuilder->reset()->setAddQueryString(TRUE)->setArgumentsToBeExcludedFromQueryString(array('tx_commentsbase_list'))->build();
		$this->redirectToUri($newUri);
	}

}
?>