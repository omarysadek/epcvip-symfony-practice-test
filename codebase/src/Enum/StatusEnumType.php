<?php

namespace App\Enum;

class StatusEnumType extends BaseEnumType
{
     const NEW_STATUS = 'new';
     const PENDING_STATUS  = 'pending';
     const IN_REVIEW_STATUS  = 'in review';
     const APPROVED_STATUS  = 'approved';
     const INACTIVE_STATUS  = 'inactive';
     const DELETED_STATUS  = 'deleted';

     protected $name = self::class;

     protected $values = [
         self::NEW_STATUS => self::NEW_STATUS ,
         self::PENDING_STATUS => self::PENDING_STATUS,
         self::IN_REVIEW_STATUS => self::IN_REVIEW_STATUS,
         self::APPROVED_STATUS => self::APPROVED_STATUS,
         self::INACTIVE_STATUS => self::INACTIVE_STATUS,
         self::DELETED_STATUS => self::DELETED_STATUS,
     ];
}