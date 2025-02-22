<?php
/*
** Zabbix
** Copyright (C) 2001-2019 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/

require_once 'vendor/autoload.php';

require_once dirname(__FILE__).'/../CElement.php';

/**
 * Multiline input element.
 */
class CMultilineElement extends CElement {

	/**
	 * Get text of Multiline element.
	 *
	 * @return string
	 */
	public function getText() {
		return $this->getValue();
	}

	/**
	 * Get value of Multiline element.
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->query('xpath:./input[@type="hidden"]')->one()->getValue();
	}

	/**
	 * Open Multiline editing overlay dialog.
	 *
	 * @return COverlayDialogElement
	 */
	public function edit() {
		$this->query('xpath:.//button[@type="button"]')->one()->click();

		return $this->query('xpath://div[@id="overlay_dialogue"]')->waitUntilVisible()->asOverlayDialog()->one()->waitUntilReady();
	}

	/**
	 * Clear Multiline input element from data.
	 *
	 * @return $this
	 */
	public function clear() {
		$dialog = $this->edit();
		$dialog->query('xpath:.//textarea[contains(@class, "multilineinput-textarea")]')->one()->clear();
		$dialog->query('button:Apply')->one()->click();

		return $this;
	}

	/**
	 * Fill Multiline input element with data.
	 *
	 * @param $text    text to be written into the field
	 *
	 * @return $this
	 */
	public function fill($text) {
		return $this->overwrite($text);
	}

	/**
	 * Overwrite value in Multiline input.
	 *
	 * @param $text    text to be written into the field
	 *
	 * @return $this
	 */
	public function overwrite($text) {
		$dialog = $this->edit();
		$dialog->query('xpath:.//textarea[contains(@class, "multilineinput-textarea")]')->one()->overwrite($text);
		$dialog->query('button:Apply')->one()->click();
		$dialog->waitUntilNotPresent();

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function type($text) {
		self::onNotSupportedMethod(__FUNCTION__);
	}

	/**
	 * @inheritdoc
	 */
	public function sendKeys($text) {
		self::onNotSupportedMethod(__FUNCTION__);
	}

	/**
	 * @inheritdoc
	 */
	public function selectValue() {
		self::onNotSupportedMethod(__FUNCTION__);
	}
}
