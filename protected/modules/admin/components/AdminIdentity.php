<?php
class AdminIdentity extends CUserIdentity
{

    /**
     * Authentication for administrators
     * @return bool
     */
    public function authenticate()
	{
        /* @var $user ExtUsers */

        $user = ExtUsers::model()->findByAttributes(array('login' => $this->username));
        
       
        //if user found
        if(!empty($user))
        {
            $salt = $user->password_salt;
            $hashed_pass = md5($this->password.$salt);

            //if password not correct
            if($user->password !== $hashed_pass)
            {
                //can't connect
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
            //if no errors
            else
            {
                //no error
                $this->errorCode = self::ERROR_NONE;

                //write params to session
                $this->setState('id',$user->id);
                $this->setState('login',$user->login);
                $this->setState('name',$user->name);
                $this->setState('surname',$user->surname);
                $this->setState('email',$user->email);
                $this->setState('role',$user->role_id);
            }
        }
        //if user not found
        else
        {
            //can't connect
            $this->errorCode = static::ERROR_USERNAME_INVALID;
        }
        
        //return error status
        return !$this->errorCode;
	}
}