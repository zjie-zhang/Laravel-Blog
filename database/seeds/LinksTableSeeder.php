<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // 数据填充
    // 创建   php artisan make:seeder LinksTableSeeder
    // 执行   php artisan db:seed --class=UserTableSeeder
    public function run()
    {
        //
        $data = [
            [
                'link_name' => 'aa',
                'link_title' => '爱语言',
                'link_url' => 'http://www.baidu.com',
                'link_order' => 1,
            ],
            [
                'link_name' => 'bb',
                'link_title' => '爱语言',
                'link_url' => 'http://www.baidu.com',
                'link_order' => 1,
            ],
            [
                'link_name' => 'cc',
                'link_title' => '爱语言',
                'link_url' => 'http://www.baidu.com',
                'link_order' => 1,
            ]
        ];
        DB::table('links')->insert($data);
    }
}
