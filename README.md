# Create Laravel api

## Requirements

- PHP >= 8.2
- Composer >= 2.4.2
- NPM >= 8.11.0
- Node >= 16.16.0
- Docker >= 20.10.17
- Docker-compose >= 1.27.4

# Install Laravel api


# Clone project

```
git clone ...
```

# Configure env

```
sudo cp .env.example .env
```

# Update env  vars

```
APP_URL=http://localhost
APP_PORT=80

VITE_APP_URL=http://localhost
VITE_APP_PORT=80

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

# Installation

```
composer install
npm install
./vendor/bin/sail up -d
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan migrate:fresh
./vendor/bin/sail php artisan jwt:secret
```

# Tests

```
./vendor/bin/sail php artisan test
```

# Documentation

```
http://localhost/documentation
```

# Patterns

- ##### Requests
    - Name: `{RequestVerb}{ModelName}Request`
    - Code example
        ```
        <?php

        namespace App\Http\Requests\Users;

        ...

        class StoreUserRequest extends FormRequest
        {
            public function authorize(): bool
            {
                return true;
            }

            public function rules(): array
            {
                return [
                    'name' => 'required|max:255',
                    'email' => ['required', 'email', Rule::unique(User::class, 'email')],
                    'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'min:6',
                ];
            }
        }

        ```

- ##### Controllers
    - Name: `{ModelName}Controller`
    - Code example
        ```
        <?php

        namespace App\Http\Controllers;

        ...

        class UserController extends Controller
        {
            private $userRepository;

            public function __construct(
                UserRepository $userRepository = null
            )
            {
                $this->userRepository = $userRepository ?? new UserRepository();
            }

            public function store(StoreUserRequest $request)
            {
                return $this->userRepository->store($request);
            }

            ...
        }

        ```

- ##### Repositories
    - Name: `{ModelName}Repository`
    - Code example
        ```
        <?php

        namespace App\Repositories;

        ...

        class UserRepository
        {
            private $user;

            public function __construct(User $user)
            {
                $this->user = $user ?? new User();
            }

            public function index(array $data): LengthAwarePaginator
            {
                $perPage = $data['per_page'] ?? 15;
                $filter = $data['filter'] ?? [];
                $sort = $data['sort'] ?? null;
                $order = $data['order'] ?? null;

                $users = $this->user::when(Arr::exists($filter, 'term', null), function ($query) use ($filter) {
                    $term = $filter['term'];
                    $query->where(function($q) use ($term) {
                        $q->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%");
                    });
                })->when(!is_null($sort) && !is_null($order), function ($query) use ($sort, $order) {
                    $query->orderBy($sort, $order);
                })->paginate($perPage);
                return $users;
            }
            ...
        }
        ```

- ##### Routes
    - Name: add or update routes in `api.php`
    - Code example
        ```
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');
        });

        Route::group(['middleware' => 'jwt.auth'], function () {
            ...

            Route::group(['prefix' => 'users'], function () {
                Route::get('index', [UserController::class, 'index'])->name('api.users.index');
                Route::post('store', [UserController::class, 'store'])->name('api.users.store');
                Route::put('update/{user}', [UserController::class, 'update'])->name('api.users.update');
                Route::get('{user}/show', [UserController::class, 'show'])->name('api.users.show');
                Route::delete('{user}/delete', [UserController::class, 'delete'])->name('api.users.delete');
            });
        });
        ```

- ##### Migrations
    - ###### Create table
        - Name: `create_{table_name}_table`
        - Code example
            ```
            <?php

            ...

            return new class extends Migration
            {
                public function up(): void
                {
                    Schema::create('users', function (Blueprint $table) {
                        $table->id();
                        $table->string('name');
                        $table->string('email')->unique();
                        $table->timestamp('email_verified_at')->nullable();
                        $table->string('password');
                        $table->rememberToken();
                        $table->timestamps();
                    });
                }

                public function down(): void
                {
                    Schema::dropIfExists('users');
                }
            };

            ```
    - ###### Add column
        - Name: `add_column_{column_name}_on_{table_name}`
        - Code example
            ```
            return new class extends Migration
            {
                public function up(): void
                {
                    if (!Schema::hasTable('users')) {
                        return;
                    }
                    
                    if (Schema::hasColumn('users', 'phone')) {
                        return;
                    }

                    Schema::table('users', function (Blueprint $table) {
                        $table->string('phone');
                    });
                }

                public function down(): void
                {
                    if (!Schema::hasTable('users')) {
                        return;
                    }
                    
                    if (!Schema::hasColumn('users', 'phone')) {
                        return;
                    }

                    Schema::table('users', function (Blueprint $table) {
                        $table->dropColumn('phone');
                    });
                }
            };
            ```
    - ###### Change column
        - Name: `change_column_{column_name}_on_{table_name}`
        - Code example
            ```
            return new class extends Migration
            {
                public function up(): void
                {
                    if (!Schema::hasTable('users')) {
                        return;
                    }
                    
                    if (!Schema::hasColumn('users', 'salary')) {
                        return;
                    }

                    Schema::table('users', function (Blueprint $table) {
                        $table->decimal('salary', 10, 4)->change();
                    });
                }

                public function down(): void
                {
                    if (!Schema::hasTable('users')) {
                        return;
                    }
                    
                    if (!Schema::hasColumn('users', 'salary')) {
                        return;
                    }

                    Schema::table('users', function (Blueprint $table) {
                        $table->bigInteger('salary')->change();
                    });
                }
            };
            ```
    - ###### Drop column
        - Name: `drop_column_{column_name}_on_{table_name}`
        - Code example
            ```
            return new class extends Migration
            {
                public function up(): void
                {
                    if (!Schema::hasTable('users')) {
                        return;
                    }

                    if (!Schema::hasColumn('users', 'salary')) {
                        return;
                    }

                    Schema::table('users', function (Blueprint $table) {
                        $table->dropColumn('salary');
                    });
                }

                public function down(): void
                {
                    if (!Schema::hasTable('users')) {
                        return;
                    }
                    
                    if (Schema::hasColumn('users', 'salary')) {
                        return;
                    }

                    Schema::table('users', function (Blueprint $table) {
                        $table->decimal('salary', 10, 4);
                    });
                }
            };
            ```
        ```
- ##### Resources
    - Name: `{ModelName}Resource`
    - Code example
        ```
        <?php

        namespace App\Http\Resources;

        ...

        class UserResource extends JsonResource
        {
            public function toArray(Request $request): array
            {
                return parent::toArray($request);
            }
        }

        ```
- ##### Services
    - Name: `{ModelName}Service`
    - Code example
        ```
        <?php

        namespace App\Services;
        
        ...

        class AuthService
        {
            public function login(string $email, string $password): Exception | array
            {
                $credentilas = ['email' => $email, 'password' => $password];
                if (!$token = auth('api')->attempt($credentilas)) {
                    throw new UnauthorizedHttpException('Unauthorized.');
                }

                return $this->respondWithToken($token);
            }
            
            ...

            private function respondWithToken(string $token, User $user = null): array
            {
                return [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60,
                    'user' => auth('api')->user() ?? $user,
                ];
            }
        }

        ```
- ##### Factories
    - Name: `{ModelName}Factory`
    - Code example
        ```
        <?php

        namespace Database\Factories;

        ...

        class UserFactory extends Factory
        {
            protected $model = User::class;

            public function definition()
            {
                return [
                    'first_name' => $this->faker->word(),
                    'last_name' => $this->faker->word(),
                    'first_name_kana' => $this->faker->name(),
                    'last_name_kana' => $this->faker->lexify(3),
                    'email' => $this->faker->safeEmail(),
                    'password' => Hash::make('password'),
                    'note' => $this->faker->text(20),
                ];
            }
        }


        ```
- 
- ##### foobarbaz3
