<?php

namespace App;

class Constants {

    const STATUSES = [
        'created',
        'processing',
        'confirmed',
        'shipped',
        'delivered',
        'rejected'
    ];
    const REGIONS = [
        'andijan',
        'bukhara',
        'jizzakh',
        'qashqadaryo',
        'navoiy',
        'namangan',
        'samarqand',
        'surxondaryo',
        'sirdaryo',
        'tashkent',
        'fergana',
        'xorazm',
        'karakalpakstan'
    ];
    const DELIVERY_METHODS = [
        'office',
        'courier',
        'courier_tashkent'
    ];
}