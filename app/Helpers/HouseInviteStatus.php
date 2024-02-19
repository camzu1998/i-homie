<?php
namespace App\Helpers;

enum HouseInviteStatus: string {
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
}
