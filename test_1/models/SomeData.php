<?php
/**
 * Test 2
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class SomeData extends ActiveRecord
{
    // ......

    private function test2($date, $type) {
        $cache_key = 'SomeData-test_2';
        $userId = Yii::$app->user->id;

        if (Yii::$app->cache->exists($cache_key)) {
            $dataList = self::find()->where(['date' => $date, 'type' => $type, 'user_id' => $userId])->all();
            Yii::$app->cache->set($cache_key, $dataList);
        }
        else {
            $dataList = Yii::$app->cache->get($cache_key);
        }

        $result = [];

        if (!empty($dataList)) {
            foreach ($dataList as $dataItem) {
                $result[$dataItem->id] = ['a' => $dataItem->a, 'b' => $dataItem->b];
            }
        }

        return $result;
    }

}