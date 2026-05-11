<?php
/**
 * LogActivity Model
 * 
 * Model untuk mencatat aktivitas user
 * 
 * @author SIPKOS Team
 */

class LogActivity extends Model
{
    protected $table = 'aktivitas_log';

    /**
     * Get activity log untuk user tertentu
     */
    public function getUserActivities($user_id, $limit = 50, $offset = 0)
    {
        return $this->getWhere(['id_user' => $user_id]);
    }

    /**
     * Get all activities
     */
    public function getAllActivities($limit = 100, $offset = 0)
    {
        return $this->getAll($limit, $offset);
    }
}

?>
