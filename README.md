# Laravel (v8) - api

- Simple api

```bash
php artisan make:controller dummyAPI
```

```php
// routes > api.php
use App\Http\Controllers\dummyAPI;

Route::get("data",[dummyAPI::class,'getData']);
```

```php
// app > Http > Controllers > dummyAPI.php

 function getData()
  {
     return ["owner" => "julfikar", "msg" => "Subhanallah"]; //must return json
  }


// Call the api from *POSTMAN : http://127.0.0.1:8000/api/data [/api have to be used]
```

- Adding data src

```bash
php artisan make:model Device
```

```php
// routes > api.php
use App\Http\Controllers\DemoController;

Route::get("list",[DemoController::class,'list']);
```

```php
use App\Models\Device;

class DemoController extends Controller
{
    function list()
    {
        return Device::all();
    }
}

// *POSTMAN : http://127.0.0.1:8000/api/list
```

- Adding params:

```php
// routes > api.php
use App\Http\Controllers\DemoController;

Route::get("list/{id}",[DemoController::class,'list']);
```

```php
use App\Models\Device;

class DemoController extends Controller
{
    function list($id)
    {
        return Device::find($id);
    }
}

// *POSTMAN : http://127.0.0.1:8000/api/list/1
```

- Adding **optional** params:

```php
// routes > api.php
use App\Http\Controllers\DemoController;

Route::get("list/{id?}",[DemoController::class,'list']);
```

```php
use App\Models\Device;

class DemoController extends Controller
{
    function list($id=null)
    {
        return $id ? Device::find($id) : Device::all();
    }
}

// *POSTMAN : http://127.0.0.1:8000/api/list/
```

- **POST** METHODS:

```php
// routes > api.php
use App\Http\Controllers\DemoController;

Route::post("add",[DemoController::class,'add']);
```

```php
// app > Models > Device.php

class Device extends Model
{
  use HasFactory;
  public $timestamp=false;
}
```

```php
use Illuminate\Http\Request;
use App\Models\Device;

class DemoController extends Controller
{
    function add(Request $req)
    {
        $device = new Device;
        $device->name = $req->name;
        $device->member_id = $req->member_id ;
        $result=$device->save();

        if($result){
            return ["Result" : "Data has been saved"];
        }
        else{
             return ["Result" : "Operation is failed"];
        }
    }
}
```

- **PUT** METHODS:

```php
// routes > api.php
use App\Http\Controllers\DemoController;

Route::put("update",[DemoController::class,'update']);
```
```php
function update(Request $req)
    {
        $device = Device::find($req->id);
        $device->name = $req->name;
        $device->member_id = $req->member_id ;
        $result=$device->save();

        if($result){
            return ["Result" : "Data has been updated"];
        }
        else{
             return ["Result" : "Update operation is failed"];
        }
    }
```

- **DELETE** METHODS:

```php
// routes > api.php
use App\Http\Controllers\DemoController;

Route::delete("delete/{id}",[DemoController::class,'delete']);
```

```php
function delete(Request $req)
    {
        $device = Device::find($req->id);
        $result=$device->delete();

        if($result){
            return ["Result" : "Data has been deleted ". $id];
        }
        else{
             return ["Result" : "Delete operation is failed"];
        }
    }
```

- Making a search

```php
// routes > api.php
use App\Http\Controllers\DemoController;

Route::get("search/{name}",[DemoController::class,'search']);
```

```php
function search($name)
    {
        return Device::where("name",$name)->get();

        // return Device::where("name","like","%".$name."%")->get(); //Char wise match
    }
```

- Validation of API

```php
use Illuminate\Http\Request;
use App\Models\Device;
use Validator;

class DemoController extends Controller
{
    function testData(Request $req)
    {
        $rules=array(
             "member_id" => "required",
             "name" => "required | max:4"
        );

        $validator = Validator::make($req->all(),$rules);

        if($validator->fails()){
            // return $validator->errors();
            return response()->json($validator->errors(),401); //Customization
        }
        else{
             $device = new Device;
             $device->name = $req->name;
             $device->member_id = $req->member_id ;
             $result=$device->save();
        }
    }
}
```

### Api with resource

- It will create some basic functions in the controller ***automatically*** like *index, create, update etc*.
- Can be added manual functions and then can be added in the route.

```bash
php artisan make:controller ApisController --resource
```

```php
// routes > api.php
use App\Http\Controllers\DemoController;

Route::apiResource("member",DemoController::class);

// // *POSTMAN : http://127.0.0.1:8000/api/member
```

### Api with sanctum

*The complete instructions are written down here :* [laravel-sanctum](https://github.com/the-julfikar/lv-starter-app)