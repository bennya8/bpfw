namespace Bzfw\Core;


class DiService implements DiServiceInterface
{

	/**
	 * Service name
	 */
	private _name;

	/**
	 * Defined use which way to resolve service 
	 * Etc class name or function closure
	 */
	private _difinition;

	/**
	 * Singleton shared
	 * @var boolean
	 */
	private _shared = false;

	/**
	 * Flag currently service resolve status
	 * @var boolean
	 */ 
	private _resolved = false;

	public function __construct(string name, definition, boolean resolved)
	{
		let this->_name = name;
		let this->_difinition = definition;
		let this->_resolved = resolved;
	}

	public function getName() -> string
	{
		return this->_name;
	}

	public function getDefinition()
	{
		return this->_difinition;
	}

	public function setDefinition(definition) -> void
	{
		let this->_difinition = definition;
	}

	public function resolve(parameters = null)
	{
		var definition, instance;

		let definition = this->_difinition;

		if (typeof definition == "string") {
			


		} elseif(typeof definition == "object") {

		}

		return instance;
	}
}