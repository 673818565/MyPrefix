# MyPrefix
a useful prefix plugin for Genisys core

本插件尚未完善
This plugin is not done now.

指令:
- /prefix help [指令幫助]
- /prefix np <稱號名> <花費> [(op權限) 創建一個新的稱號]
- /prefix set <稱號ID> [更換你自己的稱號]
- /prefix mylist [查看你自己的所有稱號]
- /prefix give <player> <prefix> [給別人稱號]

功能:
- 商店系統
- 完整的API

即將更新:
- 更多指令 與 功能

API使用方式:
- $this->MyPrefix->getPrefix($p); 獲取目前對方使用的稱號
- $this->MyPrefix->addPrefix($p, $prefix); 添加新稱號給玩家
- $this->MyPrefix->hasPrefix($p, $prefix); 檢查對方是否已有稱號
- $this->MyPrefix->getDataConfig($p); 獲取目標玩家的存檔

商店設置方法:
- 第一行：[px]
- 第二行：Cost
- 第三行：Prefix
- 第四行：介紹

捐贈連接:
- https://pl.zxda.net/plugins/317.html

Command:
- /prefix help [commands helper]
- /prefix np <prefix> <cost> [(op) create a new preifx]
- /prefix set <prefixID> [change your own prefix]
- /prefix mylist [see all of your prefix]
- /prefix give <player> <prefix> [give a player a prefix]

Features:
- Prefix Shop
- Better prefix api

Todo:
- More commands and features

API:
- $this->MyPrefix->getPrefix($p); [get player's prefix and use this function in chat event]
- $this->MyPrefix->addPrefix($p, $prefix); [give a player a prefix]
- $this->MyPrefix->hasPrefix($p, $prefix); [Check player had the prefix]
- $this->MyPrefix->getDataConfig($p); [get player's data config]

Setting Shops:
- Line 1：[px]
- Line 2：Cost
- Line 3：Prefix
- Line 4：Introduction

Donation URL:
- https://pl.zxda.net/plugins/317.html
