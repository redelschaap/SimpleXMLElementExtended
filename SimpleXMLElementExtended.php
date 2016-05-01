<?php

	/**
	 * Class SimpleXMLElementExtended
	 *
	 * A simple extended version of SimpleXMLElement that adds CDATA whenever necessary
	 *
	 * @author  Ronald Edelschaap <rlwedelschaap@gmail.com> <first autohor>
	 * @updated 01-05-2016
	 * @license http://www.gnu.org/licenses/gpl-2.0 GPL v2.0
	 * @version 1.0
	 */
	class SimpleXMLElementExtended extends SimpleXMLElement {

		/**
		 * @inheritdoc SimpleXMLElement::addChild
		 *
		 * @return SimpleXMLElement|SimpleXMLElementExtended
		 */
		public function addChild( $name, $value = null, $namespace = null ) {
			$_value = self::replaceHTMLSpecialChars( (string) $value, true );

			if ( $_value !== '' && ( strpos( $_value, '<' ) !== false || strpos( $_value, '>' ) !== false || strpos( $_value, '&' ) !== false ) ) {
				$child = $this->addChild( $name, null, $namespace );
				$child->addCData( $value );

				return $child;
			}

			return parent::addChild( $name, $value, $namespace );
		}

		/**
		 * Add CDATA text in a node
		 *
		 * @param string $value The value to add
		 */
		private function addCData( $value ) {
			$node  = dom_import_simplexml( $this );
			$owner = $node->ownerDocument;
			$node->appendChild( $owner->createCDATASection( $value ) );
		}

		/**
		 * Replaces html characters with their html codes, or reversed when $reversed is TRUE
		 *
		 * @param array|string $html
		 * @param bool         $reversed
		 *
		 * @return array|string Returns the converted result
		 */
		private static function replaceHTMLSpecialChars( $html, $reversed = false ) {
			/** @noinspection PhpDuplicateArrayKeysInspection */
			$special_chars = [
				'&'  => '&amp;',
				'"'  => '&quot;',
				'"'  => '&#034;',
				'‘'  => '&lsquo;',
				'‘'  => '&#039;',
				'’'  => '&rsquo;',
				'"'  => '&#34;',
				'\'' => '&#39;',
				'\'' => '&#039;',
				'‚'  => '&sbquo;',
				'“'  => '&ldquo;',
				'”'  => '&rdquo;',
				'„'  => '&bdquo;',
				'†'  => '&dagger;',
				'‡'  => '&Dagger;',
				'‰'  => '&permil;',
				'‹'  => '&lsaquo;',
				'›'  => '&rsaquo;',
				'♠'  => '&spades;',
				'♣'  => '&clubs;',
				'♥'  => '&hearts;',
				'♦'  => '&diams;',
				'‾'  => '&oline;',
				'←'  => '&larr;',
				'↑'  => '&uarr;',
				'→'  => '&rarr;',
				'↓'  => '&darr;',
				'™'  => '&trade;',
				'“'  => '&quot;',
				'%'  => '&#37;',
				'<'  => '&lt;',
				'>'  => '&gt;',
				'`'  => '&#96;',
				'~'  => '&#126;',
				'—'  => '-',
				'–'  => '-',
				'-'  => '-',
				'¢'  => '&cent;',
				'£'  => '&pound;',
				'€'  => '&euro;',
				'¤'  => '&curren;',
				'¥'  => '&yen;',
				'¦'  => '&#166;',
				'§'  => '&sect;',
				'¨'  => '&#168;',
				'©'  => '&copy;',
				'ª'  => '&ordf;',
				'«'  => '&laquo;',
				'¬'  => '&not;',
				'®'  => '&reg;',
				'¯'  => '&#175;',
				'°'  => '&deg;',
				'±'  => '&plusmn;',
				'²'  => '&sup2;',
				'³'  => '&sup3;',
				'´'  => '&acute;',
				'µ'  => '&micro;',
				'¶'  => '&para;',
				'·'  => '&middot;',
				'¸'  => '&cedil;',
				'¹'  => '&sup1;',
				'º'  => '&ordm;',
				'»'  => '&raquo;',
				'¼'  => '&frac14;',
				'½'  => '&frac12;',
				'¾'  => '&frac34;',
				'À'  => '&Agrave;',
				'Á'  => '&Aacute;',
				'Â'  => '&Acirc;',
				'Ã'  => '&Atilde;',
				'Ä'  => '&Auml;',
				'Å'  => '&Aring;',
				'Æ'  => '&AElig;',
				'Ç'  => '&Ccedil;',
				'È'  => '&Egrave;',
				'É'  => '&Eacute;',
				'Ê'  => '&Ecirc;',
				'Ë'  => '&Euml;',
				'Ğ'  => '&#286;',
				'Ì'  => '&Igrave;',
				'Í'  => '&Iacute;',
				'Î'  => '&Icirc;',
				'Ï'  => '&Iuml;',
				'Ð'  => '&ETH;',
				'Ñ'  => '&Ntilde;',
				'Ò'  => '&Ograve;',
				'Ó'  => '&Oacute;',
				'Ô'  => '&Ocirc;',
				'Õ'  => '&Otilde;',
				'Ö'  => '&Ouml;',
				'×'  => '&times;',
				'Ø'  => '&Oslash;',
				'Ù'  => '&Ugrave;',
				'Ú'  => '&Uacute;',
				'Û'  => '&Ucirc;',
				'Ü'  => '&Uuml;',
				'Ý'  => '&Yacute;',
				'Þ'  => '&THORN;',
				'ß'  => '&szlig;',
				'à'  => '&agrave;',
				'á'  => '&aacute;',
				'â'  => '&acirc;',
				'ã'  => '&atilde;',
				'ä'  => '&auml;',
				'å'  => '&aring;',
				'æ'  => '&aelig;',
				'ç'  => '&ccedil;',
				'è'  => '&egrave;',
				'é'  => '&eacute;',
				'ê'  => '&ecirc;',
				'ë'  => '&euml;',
				'ğ'  => '&#287;',
				'ì'  => '&igrave;',
				'í'  => '&iacute;',
				'î'  => '&icirc;',
				'ï'  => '&iuml;',
				'ð'  => '&eth;',
				'ñ'  => '&ntilde;',
				'ò'  => '&ograve;',
				'ó'  => '&oacute;',
				'ô'  => '&ocirc;',
				'õ'  => '&otilde;',
				'ö'  => '&ouml;',
				'÷'  => '&divide;',
				'ø'  => '&oslash;',
				'ù'  => '&ugrave;',
				'ú'  => '&uacute;',
				'û'  => '&ucirc;',
				'ü'  => '&uuml;',
				'ý'  => '&yacute;',
				'þ'  => '&thorn;',
				'ÿ'  => '&yuml;',
			];

			if ( $reversed === true ) {
				$special_chars = array_flip( $special_chars );
			}

			if ( is_array( $html ) ) {
				foreach ( $html as &$data_val ) {
					$data_val = str_replace_html_special_chars( $data_val, $reversed );

					unset( $data_val );
				}
			} else {
				foreach ( $special_chars as $key => $value ) {
					$html = str_ireplace( $key, $value, $html );
				}
			}

			return $html;
		}
	}
