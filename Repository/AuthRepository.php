<?php

declare(strict_types=1);

namespace Repository;

use Exception;
use NW\Connection;
use NW\Cookie;
use Portal\Account\Energy\EnergyFactory;
use Portal\Account\Notice\NoticeFactory;
use Portal\Auth\AuthFactory;
use Portal\Auth\AuthInterface;

class AuthRepository
{
    /**
     * @return AuthInterface|null
     * @throws Exception
     */
    public static function getAuth(): ?AuthInterface
    {
        if (!Cookie::checkCookie('hash')) {
            return null;
        }

        $connection = Connection::getInstance();

        $data = $connection->query(
            'SELECT 
            `accounts`.`id`, 
            `accounts`.`login`, 
            `accounts`.`name`, 
            `accounts`.`hash`, 
            `accounts`.`reg_date`, 
            `accounts`.`ip`, 
            `accounts`.`ref`, 
            `accounts`.`mail`, 
            `accounts`.`floor_id`, 
            `accounts`.`status_id` as `account_status_id`, 
            `accounts`.`group_id` as `account_group_id`, 
            `accounts`.`char_active_id`, 
            `accounts`.`upload`, 
            `accounts`.`chat_status_id`,
            `accounts`.`can_like`,
            
            `accounts`.`energy_id` as `account_id`,
            
            `account_energy`.`id` as `energy_id`,
            `account_energy`.`energy` as `energy`,
            `account_energy`.`updated_at` as `energy_updated_at`,
            `account_energy`.`residue` as `energy_residue`

            FROM `accounts`
            
            JOIN `account_energy` ON `accounts`.`energy_id` = `account_energy`.`id`

            WHERE `accounts`.`hash` = ?',
            [['type' => 's', 'value' => (string)Cookie::getCookie('hash')]],
            true
        );

        if (!$data) {
            return null;
        }

        $authFactory = new AuthFactory(new EnergyFactory(), new NoticeFactory());

        $data['avatar'] = 'ava.jpg';
        $data['can_like'] = (bool)$data['can_like'];
        $data['notices'] = [];
        $data['level'] = 1;
        $data['stat_points'] = 0;

        $data['energy'] = [
            'energy_id' => $data['energy_id'],
            'account_id' => $data['id'],
            'energy' => $data['energy'],
            'energy_bonus' => 0,
            'energy_updated_at' => (float)$data['energy_updated_at'],
            'energy_residue' => $data['energy_residue'],
        ];

        return $authFactory->create($data);
    }
}
