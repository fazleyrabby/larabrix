<?php

namespace App\Enums;

enum MenuType: string
{
    case Header = 'header';
    case Footer = 'footer';
    case Sidebar = 'sidebar';
    // Add more if needed
}