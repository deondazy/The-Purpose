<?php 

namespace Core\Models;

use Core\Models\Base;

class Setting extends Base
{
    protected $table = 'settings';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }

    /**
     * Get setting from DB
     * 
     * @param name
     * 
     * @return string|null
     */
    public function getSetting($name)
    {
        return $this->getAll('value', ['where' => ['name' => $name]])[0]['value'] ?? null;
    }

    /**
     * Add setting to DB
     * 
     * @param name
     * @param value
     * 
     * @return bool
     */
    public function addSetting($name, $value)
    {
        $setting = $this->getSetting($name);

        if (is_null($setting)) {
            return (bool) $this->create([
                'name' => $name,
                'value' => $value,
            ]);
        }

        return false;
    }

    /**
     * Update setting in DB
     * 
     * @param name
     * @param value
     * 
     * @return bool
     */
    public function updateSetting($name, $value)
    {
        $setting = $this->getSetting($name);

        if (is_null($setting)) {
            return false;
        }

        if ($setting == $value) {
            return false;
        }

        return (bool) $this->update(['name' => $name], [
            'value' => $value
        ]);
    }
}
