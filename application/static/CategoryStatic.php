<?php defined('BASEPATH') or exit('No direct script access allowed');

// categories

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(11) No
// parent_id   int(11) No  0
// name    varchar(100)    No
// icon    varchar(100)    Yes     NULL
// image   varchar(100)    Yes     NULL
// description text    Yes     NULL
// code    varchar(5)  No
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class CategoryStatic
{
    // TODO: Sementara belum input ke table categories
    const CATEGORIES =
    [
        1 => "Art Design and Culture",
        15 => "Business",
        21 => "F&B",
        25 => "Lifestyle",
        30 => "Parenting and Family",
        34 => "Tech"
    ];
}
