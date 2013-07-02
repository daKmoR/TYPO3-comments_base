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
class Comment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * identifies where this comment belongs to
	 *
	 * @var \string
	 */
	protected $entryId;

	/**
	 * @var \string
	 */
	protected $text;

	/**
	 * @var \string
	 */
	protected $authorName;

	/**
	 * @var \string
	 */
	protected $authorEmail;

	/**
	 * @var \string
	 */
	protected $authorUrl;

	/**
	 * @var integer
	 */
	protected $createDate;

	/**
	 * @var \TYPO3\CommentsBase\Domain\Model\FrontendUser
	 */
	protected $author;

	/**
	 * @var \TYPO3\CommentsBase\Domain\Model\Comment
	 */
	protected $parent;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CommentsBase\Domain\Model\Comment>
	 */
	protected $children;

	/**
	 * @var boolean
	 */
	protected $disabled;

	/**
	 * The Uri where the comment was originally added
	 *
	 * @var string
	 */
	protected $uri;

	/**
	 * @return \string $entryId
	 */
	public function getEntryId() {
		return $this->entryId;
	}

	/**
	 * @param \string $entryId
	 * @return void
	 */
	public function setEntryId($entryId) {
		$this->entryId = $entryId;
	}

	/**
	 * @return \string $text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @param \string $text
	 * @return void
	 */
	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * @return \string $authorName
	 */
	public function getAuthorName() {
		return $this->authorName;
	}

	/**
	 * @param \string $authorName
	 * @return void
	 */
	public function setAuthorName($authorName) {
		$this->authorName = $authorName;
	}

	/**
	 * @return \string $authorEmail
	 */
	public function getAuthorEmail() {
		return $this->authorEmail;
	}

	/**
	 * @param \string $authorEmail
	 * @return void
	 */
	public function setAuthorEmail($authorEmail) {
		$this->authorEmail = $authorEmail;
	}

	/**
	 * @return \string $authorUrl
	 */
	public function getAuthorUrl() {
		return $this->authorUrl;
	}

	/**
	 * @param \string $authorUrl
	 * @return void
	 */
	public function setAuthorUrl($authorUrl) {
		$this->authorUrl = $authorUrl;
	}

	/**
	 * @return \TYPO3\CommentsBase\Domain\Model\FrontendUser $author
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\FrontendUser $author
	 * @return void
	 */
	public function setAuthor(\TYPO3\CommentsBase\Domain\Model\FrontendUser $author) {
		$this->author = $author;
	}

	/**
	 * @param int $createDatetime
	 */
	public function setCreateDate($createDatetime) {
		$this->createDate = $createDatetime;
	}

	/**
	 * @return int
	 */
	public function getCreateDate() {
		return $this->createDate;
	}

	/**
	 * @param boolean $disabled
	 */
	public function setDisabled($disabled) {
		$this->disabled = $disabled;
	}

	/**
	 * @return boolean
	 */
	public function getDisabled() {
		return $this->disabled;
	}

	/**
	 * @param string $uri
	 */
	public function setUri($uri) {
		$this->uri = $uri;
	}

	/**
	 * @return string
	 */
	public function getUri() {
		return $this->uri;
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $parent
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}

	/**
	 * @return \TYPO3\CommentsBase\Domain\Model\Comment
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $children
	 */
	public function setChildren($children) {
		$this->children = $children;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @return void
	 */
	public function addChild(\TYPO3\CommentsBase\Domain\Model\Comment $comment) {
		 $this->children->attach($comment);
	}

	/**
	 * @param \TYPO3\CommentsBase\Domain\Model\Comment $comment
	 * @return void
	 */
	public function removeChild(\TYPO3\CommentsBase\Domain\Model\Comment $comment) {
		 $this->children->detach($comment);
	}

	/**
	 * @param int $languageUid
	 */
	public function setLanguageUid($languageUid) {
		$this->_languageUid = $languageUid;
	}

	/**
	 * @return int
	 */
	public function getLanguageUid() {
		return $this->_languageUid;
	}

}
?>