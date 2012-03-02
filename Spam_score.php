<?php
  /**
   * StatusNet - the distributed open-source microblogging tool
   * Copyright (C) 2011, StatusNet, Inc.
   *
   * Score of a notice by activity spam service
   * 
   * PHP version 5
   *
   * This program is free software: you can redistribute it and/or modify
   * it under the terms of the GNU Affero General Public License as published by
   * the Free Software Foundation, either version 3 of the License, or
   * (at your option) any later version.
   *
   * This program is distributed in the hope that it will be useful,
   * but WITHOUT ANY WARRANTY; without even the implied warranty of
   * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   * GNU Affero General Public License for more details.
   *
   * You should have received a copy of the GNU Affero General Public License
   * along with this program.  If not, see <http://www.gnu.org/licenses/>.
   *
   * @category  Spam
   * @package   StatusNet
   * @author    Evan Prodromou <evan@status.net>
   * @copyright 2011 StatusNet, Inc.
   * @license   http://www.fsf.org/licensing/licenses/agpl-3.0.html AGPL 3.0
   * @link      http://status.net/
   */

if (!defined('STATUSNET')) {
    exit(1);
}

/**
 * Score of a notice per the activity spam service
 *
 * @category Spam
 * @package  StatusNet
 * @author   Evan Prodromou <evan@status.net>
 * @license  http://www.fsf.org/licensing/licenses/agpl.html AGPLv3
 * @link     http://status.net/
 *
 * @see      DB_DataObject
 */

class Spam_score extends Managed_DataObject
{
    const MAX_SCALED = 1000000;
    public $__table = 'spam_score'; // table name

    public $notice_id;   // int
    public $score;       // float
    public $created;     // datetime

    /**
     * Get an instance by key
     *
     * @param string $k Key to use to lookup (usually 'notice_id' for this class)
     * @param mixed  $v Value to lookup
     *
     * @return Spam_score object found, or null for no hits
     *
     */
    function staticGet($k, $v=null)
    {
        return Managed_DataObject::staticGet('Spam_score', $k, $v);
    }

    /**
     * The One True Thingy that must be defined and declared.
     */
    public static function schemaDef()
    {
        return array(
            'description' => 'score of the notice per activityspam',
            'fields' => array(
                'notice_id' => array('type' => 'int',
                                     'not null' => true,
                                     'description' => 'notice getting scored'),
                'score' => array('type' => 'double',
                                 'not null' => true,
                                 'description' => 'score for the notice (0.0, 1.0)'),
                'scaled' => array('type' => 'int',
                                  'description' => 'scaled score for the notice (0, 1000000)'),
                'is_spam' => array('type' => 'tinyint',
                                   'description' => 'flag for spamosity'),
                'created' => array('type' => 'datetime',
                                   'not null' => true,
                                   'description' => 'date this record was created'),
                'notice_created' => array('type' => 'datetime',
                                          'description' => 'date the notice was created'),
            ),
            'primary key' => array('notice_id'),
            'foreign keys' => array(
                'spam_score_notice_id_fkey' => array('notice', array('notice_id' => 'id')),
            ),
            'indexes' => array(
                'spam_score_created_idx' => array('created'),
                'spam_score_scaled_idx' => array('scaled'),
            ),
        );
    }
}
