Blockwordの中の　ワード最大、3つまでを　25m　　見れる　ようにする（その日に限る）
一日2回まで　その操作が可能。

ようなプログラムを作成する

wordテーブルのcolumn にdisableFlg(bool)を追加　
if it is 1, disabling word block.

毎日00:00にテーブル内のすべてのデータのflgを0に戻す。


＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
I don't know how to create program limiting to 3 words a day.

#### PLAN A

disable buttonをclickした際に、havingを使って、flgが1のレコードが4つ以上ないか
あれば処理中断。

#### PLAN B




