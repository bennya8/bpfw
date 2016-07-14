namespace Bzfw\Core;

class Di
{

	/**
		 * Class instances container
		 * @var array
		 */
		private static _instances = [];

		/**
		 * Self instance
		 * @var Bzfw\Core\DI
		 */
		private static _handle = null; 

		/**
		 * DI factory method
		 * @return object
		 */
		public static function factory()
		{
			var handle;
			let handle = self::_handle;
			if !handle {
				let self::_handle = new self;
			}
			return self::_handle;
		}

		public function get(string! name)
		{

		}
		

		public function set(string! name, definition)
		{
		}
		
		public function has(string! name)
		{


		}

		private function __construct() {}
		private function __clone() {}


}