## Model 应用共用模型

***Example***

```php
namespace App\Model;

use System\Core\Model;

class User extends Model{

    protected $pk = 'id';

    protected $table = 'user';

}
```