<?php

namespace Controllers;

use Illuminate\Auth\Authenticatable;
use App\Model as AppModel;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @property string $firstname
 * @property string $lastname
 * @property string $profile
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereProfile($value)
 */
class User
        extends AppModel
        implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden                    = ['password', 'remember_token'];
    /**
     * Validation rules to be used by createFromInput static method
     * @var array
     */
    protected static $validationRules = [

        'firstname' => [
            'required'
        ],
        'lastname'  => [
            'required'
        ],
        'email'     => [
            'required'
        ],
    ];

    /**
     * Custom validation messages
     * @var type
     */
    protected static $validationMessages = [
    ];

    /**
     * Fields available for createFromInput method
     * @var array
     */
    protected static $availableFields    = [
        'email',
        'firstname',
        'lastname',
    ];

    public static function createFromInput(\Controllers\Request $input, $id = null, $save = true) {
        $user = parent::createFromInput($input, $id, false);

        if ($input->has('password') && '' != $input->get('password')) {
            $user->password = bcrypt($input->get('password'));
        }

        if ($save) {
            $user->save();
        }

        return $user;
    }

}
