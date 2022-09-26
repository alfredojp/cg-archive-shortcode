<?php
/**
 * Testimonial Shortcode Factory
 *
 * @package      CG/Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

class TestimonialShortcodeFactory implements ArchiveShortcodeFactory {

	public function fetchArchiveShortcodeTemplate() {
		return new TestimonialShortcodeTemplate();
	}

}
