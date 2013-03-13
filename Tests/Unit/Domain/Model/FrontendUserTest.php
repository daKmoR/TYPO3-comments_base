<?php

namespace TYPO3\CommentsBase\Tests;
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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \TYPO3\CommentsBase\Domain\Model\FrontendUser.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Comments
 *
 * @author Thomas Allmer <d4kmor@gmail.com>
 */
class FrontendUserTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \TYPO3\CommentsBase\Domain\Model\FrontendUser
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \TYPO3\CommentsBase\Domain\Model\FrontendUser();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getCommentsReturnsInitialValueForComment() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getComments()
		);
	}

	/**
	 * @test
	 */
	public function setCommentsForObjectStorageContainingCommentSetsComments() { 
		$comment = new \TYPO3\CommentsBase\Domain\Model\Comment();
		$objectStorageHoldingExactlyOneComments = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneComments->attach($comment);
		$this->fixture->setComments($objectStorageHoldingExactlyOneComments);

		$this->assertSame(
			$objectStorageHoldingExactlyOneComments,
			$this->fixture->getComments()
		);
	}
	
	/**
	 * @test
	 */
	public function addCommentToObjectStorageHoldingComments() {
		$comment = new \TYPO3\CommentsBase\Domain\Model\Comment();
		$objectStorageHoldingExactlyOneComment = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneComment->attach($comment);
		$this->fixture->addComment($comment);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneComment,
			$this->fixture->getComments()
		);
	}

	/**
	 * @test
	 */
	public function removeCommentFromObjectStorageHoldingComments() {
		$comment = new \TYPO3\CommentsBase\Domain\Model\Comment();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($comment);
		$localObjectStorage->detach($comment);
		$this->fixture->addComment($comment);
		$this->fixture->removeComment($comment);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getComments()
		);
	}
	
}
?>