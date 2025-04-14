<?php
/**
 * dn-tools-for-klaviyo
 *
 * @package       DIGITAL_NATURE_TOOLS_FOR_KLAVIYO
 * @author        Digital Nature
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Digital Nature - Tools for Klaviyo
 * Plugin URI:    https://www.digital-nature.co.uk
 * Requires Plugins: dn-utilities
 * Description:   Tools for Klaviyo, send events and send & sync attributes with Klaviyo profiles
 * Version:       1.0.0
 * Author:        Digital Nature
 * Author URI:    https://www.digital-nature.co.uk
 * Text Domain:   dn-tools-for-klaviyo
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with dn-tools-for-klaviyo. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

use DigitalNature\ToolsForKlaviyo\Bootstrap;
use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Bring in the autoloader
 */
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// bootstrap the plugin once the rest have loaded
add_action('plugins_loaded', 'bootstrap_plugin_dn_tools_for_klaviyo');

function bootstrap_plugin_dn_tools_for_klaviyo()
{
    PluginConfig::configure(__FILE__, '1.0.0');
    Bootstrap::instance();
}
