<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DiariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = DB::table('users')->first();

        $diaries = [
            [
                'title' => 'セブでプログラミング',
                'body'  => '気づけばもうすぐ2ヶ月',
            ],
            [
                'title' => '週末は旅行',
                'body'  => 'オスロブに行ってジンベエザメと泳ぎました',
            ],
            [
                'title' => '英語授業',
                'body'  => '楽しい',
            ],
        ];

        foreach ($diaries as $diary) {

            DB::table('diaries')->insert([
                'title' => $diary['title'],
                'body' => $diary['body'],
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
