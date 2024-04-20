<?php

namespace App\Models;


use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\Enterprise\Enterprise;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'phone_number',
        'local_number',
        'api_token',
        'rejected_change_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function userExistsByEmail(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public static function createUser(array $data): User
    {
        return User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone_number' => $data['phone_number'],
                'local_number' => $data['local_number'],
            ]
        )->assignRole('normal');
    }

    public static function getAllUsers($request, $skip, $take)
    {
        $users = User::where('status', true);
        // Aplicando tres tipos de filtro, email, name y rol
        if ($request->email <> "") $users = $users->where('email', 'ilike', '%' . $request->email . '%');
        if ($request->name <> "") $users = $users->where('name', 'ilike', '%' . $request->name . '%');
        $users = $request->rol <> "" ? $users->with(['roles'  => function ($query) use ($request) {$query->where('name', 'ilike', '%' . $request->rol . '%');}]) : $users->with(['roles']);
        // Aplicando paginado de los registros
        return $users->skip($skip)->take($take)->get();
    }

    // Obteniendo todos los usuarios que tienen empresas, junto con sus roles y empresa
    public static function getEnterpriseUsers($request, $skip, $take){
        $users = User::join('enterprises', 'users.id', '=', 'enterprises.user_id');
        // Aplicando tres tipos de filtro, email, name, rol y nombre empresa
        if ($request->user_email <> "") $users = $users->where('users.email', 'ilike', '%' . $request->user_email . '%');
        if ($request->user_name <> "") $users = $users->where('users.name', 'ilike', '%' . $request->user_name . '%');
        $users = $request->rol <> "" ? $users->with(['roles'  => function ($query) use ($request) {$query->where('roles.name', 'ilike', '%' . $request->rol . '%');}]) : $users->with(['roles']);
        $users = $request->enterprise_name <> "" ? $users->with(['enterprise'  => function ($query) use ($request) {$query->where('enterprise.name', 'ilike', '%' . $request->enterprise_name . '%');}]) : $users->with(['enterprise']);
        // Aplicando paginado de los registros
        return $users->skip($skip)->take($take)->get();
    }

    public function enterprise()
    {
        return $this->hasOne(Enterprise::class);
    }
}
