<?php

/**
 * Copyright (c) 2013 iControlWP <support@icontrolwp.com>
 * All rights reserved.
 *
 * "WordPress Twitter Bootstrap CSS" (formerly "WordPress Bootstrap CSS") is
 * distributed under the GNU General Public License, Version 2,
 * June 1991. Copyright (C) 1989, 1991 Free Software Foundation, Inc., 51 Franklin
 * St, Fifth Floor, Boston, MA 02110, USA
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

require_once( dirname(__FILE__).'/hlt-bootstrap-less-base.php' );

if ( !class_exists('HLT_BootstrapLess') ):

class HLT_BootstrapLess extends HLT_BootstrapLess_Base {
	
	const LessOptionsPrefix = 'less_';
	
	static public $LESS_PREFIX;
	static public $LESS_OPTIONS_DB_KEY = 'all_less_options';
	
	public function compileAllBootstrapLess() {
		parent::compileAllBootstrapLess();
		$this->compileLess( 'responsive' );
	}
	
	/**
	 * @param $insCompileTarget - currently only either 'bootstrap' or 'responsive'
	 */
	public function compileLess( $insCompileTarget = 'bootstrap' ) {
		
		if ( empty($this->m_sBsDir) ) {
			return false;
		}
		
		$sFilePathToLess = $this->m_sBsDir.'less'.ICWP_DS.$insCompileTarget.'.less';
		
		//parse LESS
		if ( !class_exists( 'lessc' ) ) {
			include_once( dirname(__FILE__).'/inc/lessc/lessc.inc.php' );
		}
		elseif ( lessc::$VERSION != 'v0.4.0' ) { //not running a supported version of the less compiler for bootstrap
			return false;
		}

		// New method
		$oLessCompiler = new lessc();

		// Original method
		//$oLessCompiler = new lessc( $sFilePathToLess );
		
		$sCompiledCss = '';
		
		try {
			/**
			 * New Method (to use new lessphp interface)
			 * 
			 * 1. Determine target filename(s)
			 * 2. Compile + write to disk
			 * 3. Compile + compress + write to disk
			 */
			
			if ( $insCompileTarget == 'responsive' ) {
				$sLessFile = $this->m_sBsDir.'css'.ICWP_DS.'bootstrap-responsive.less';
			}
			else if ($insCompileTarget == 'bootstrap') {
				$sLessFile = $this->m_sBsDir.'css'.ICWP_DS.'bootstrap.less';
			}
			else { //Are there others?
				$sLessFile = $this->m_sBsDir.'css'.ICWP_DS.'bootstrap.less';
			}
			
			// Write normal CSS
			$oLessCompiler = new lessc();
			$oLessCompiler->compileFile( $sFilePathToLess, $sLessFile.'.css' );
			
			// Write compress CSS
			$oLessCompiler = new lessc(); //as of version 0.4.0 I have to recreate the object.
			$oLessCompiler->setFormatter( "compressed" );
			$oLessCompiler->compileFile( $sFilePathToLess, $sLessFile.'.min.css' );
			
			/**
			 * Original method
			 * 
			 * 1. Compile
			 * 2. Determine target filename(s)
			 * 3. Write to disk
			 * 4. Compress/Minify
			 * 5. Write to disk
			 */
			/*
			$sCompiledCss = $oLessCompiler->parse();
			
			if ($insCompileTarget == 'responsive') {
				$sLessFile = $this->m_sBsDir.'css'.ICWP_DS.'bootstrap-responsive.less';
			} else if ($insCompileTarget == 'bootstrap') {
				$sLessFile = $this->m_sBsDir.'css'.ICWP_DS.'bootstrap.less';
			} else { //Are there others?
				$sLessFile = $this->m_sBsDir.'css'.ICWP_DS.'bootstrap.less';
			}
			
			file_put_contents( $sLessFile.'.css', $sCompiledCss );
		
			//Basic Minify
			$sCompiledCss = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $sCompiledCss);
			file_put_contents( $sLessFile.'.min.css', $sCompiledCss );
			*/
		}
		catch ( Exception $oE ) {
			echo "lessphp fatal error: ".$oE->getMessage();
		}
	}
	
}

endif;
