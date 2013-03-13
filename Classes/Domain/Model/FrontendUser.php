<?php
namespace TYPO3\CommentsBase\Domain\Model;

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
class FrontendUser extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser {

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CommentsBase\Domain\Model\Comment>
	 */
	protected $comments;

	/**
	 * __construct
	 *
	 * @return FrontendUser
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->comments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @return void
	 */
	public function addComment(\TYPO3\CommentsBase\Domain\Model\Comment $comment) {
		$this->comments->attach($comment);
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $commentToRemove The Comment to be removed
	 * @return void
	 */
	public function removeComment(\TYPO3\CommentsBase\Domain\Model\Comment $commentToRemove) {
		$this->comments->detach($commentToRemove);
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CommentsBase\Domain\Model\Comment> $comments
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CommentsBase\Domain\Model\Comment> $comments
	 * @return void
	 */
	public function setComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $comments) {
		$this->comments = $comments;
	}

}
?>