<?php


namespace app\models;

use app\machina\UserModel;

/**
 * Description of RegisterModel
 *
 * @author darko
 */
class User extends UserModel {
    
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    
    
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE; 
    public string $created_at = '';
    public string $password = '';
    public string $confirmPassword = '';
    
    public static function primaryKey(): string {
        return 'id';
    }
    
    public function save() {
        
        $this->status = self::STATUS_INACTIVE;
        
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        
        return parent::save();        
        
    }

    public function rules(): array {
        
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 50]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
        
    }
    
    public function attributes(): array {
        
        return ['firstname', 'lastname', 'email', 'password', 'status'];                    
        
    }
    
    
    public static function tableName(): string {
        
        return 'users';
        
    }
    
    public function labels(): array {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
        ];
    }

    public function getDisplayName(): string {
        
        return $this->firstname . ' ' . $this->lastname;
        
    }

}
