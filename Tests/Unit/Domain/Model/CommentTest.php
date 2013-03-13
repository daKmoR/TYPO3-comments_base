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
 * Test case for class \TYPO3\CommentsBase\Domain\Model\Comment.
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
class CommentTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \TYPO3\CommentsBase\Domain\Model\Comment
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \TYPO3\CommentsBase\Domain\Model\Comment();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getEntryIdReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setEntryIdForStringSetsEntryId() { 
		$this->fixture->setEntryId('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getEntryId()
		);
	}
	
	/**
	 * @test
	 */
	public function getTextReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTextForStringSetsText() { 
		$this->fixture->setText('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getText()
		);
	}
	
	/**
	 * @test
	 */
	public function getAuthorNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setAuthorNameForStringSetsAuthorName() { 
		$this->fixture->setAuthorName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getAuthorName()
		);
	}
	
	/**
	 * @test
	 */
	public function getAuthorEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setAuthorEmailForStringSetsAuthorEmail() { 
		$this->fixture->setAuthorEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getAuthorEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getAuthorUrlReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setAuthorUrlForStringSetsAuthorUrl() { 
		$this->fixture->setAuthorUrl('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getAuthorUrl()
		);
	}
	
	/**
	 * @test
	 */
	public function getAuthorReturnsInitialValueForFrontendUser() { }

	/**
	 * @test
	 */
	public function setAuthorForFrontendUserSetsAuthor() { }
	
}
?>