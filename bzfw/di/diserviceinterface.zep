namespace Bzfw\Di;

interface DiServiceInterface
{

	public function __construct(string name, definition, boolean resolved);

	public function getName();

	public function getDefinition();

	public function setDefinition(definition);

	public function resolve(parameters = null);

}