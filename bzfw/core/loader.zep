
/**
 * Loader
 * @namespace Bzfw\Core
 * @package bzfw.core.loader
 * @author Benny <benny_a8@live.com>
 * @copyright ©2016 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Bzfw\Core;

class Loader
{
    
    /**
     * Namespace mapping
     * @var array
     */
    private static _namespaces = [];

    /**
     * Classes mapping
     * class namespaces => class path
     * @var array
     */
    private static _classes = [];

    /**
     * Register application autoload function
     * @retun void
     */
    public function register()
    {
    	if !function_exists("spl_autoload_register") {
    		throw new Exception("spl_autoload_register function not exists");
    	}
        spl_autoload_register([this, "autoload"]);
    }

    /**
     * Unregister application autoload function
     * @retun void
     */
    public function unRegister()
    {
    	if !function_exists("spl_autoload_unregister") {
    		throw new Exception("spl_autoload_unregister function not exists");
    	}
        spl_autoload_unregister([this, "autoload"]);
    }









}