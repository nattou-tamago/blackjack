# blackjack - ブラックジャック -

コンソール（ターミナル）上でできるブラックジャックゲームです。

## ゲームのキャプチャ

<img src="https://user-images.githubusercontent.com/88647501/173173900-3edb4cd6-77d9-4a02-8687-1d71c4912f69.png" alt="image">

## ルール

- ジョーカーを除く52枚のカードを使用。
- プレイヤーとディーラーとの勝負。
- カードの点数が21に近いほうの勝ち。
- カードの点数が22以上になると、「バスト」となり負け。
- カードの点数
    - 「2～10」は数字のとおりの点数
    - 「A」は1または11とカウント。手持ちのカードがバストしないで、最大となる点数のほうでカウント。
    - 「J、Q、K」の絵柄カードの点数は全て10。
- ゲーム開始後、プレイヤーとディーラーにそれぞれ2枚ずつカードが配られる。ただし、ディーラーの2枚目のカードは、画面に表示されず分からない。
- プレイヤーは自分のカードの点数が21に近づくように、カードを追加するか、追加しないかを決める。
    - 「ヒット」はカードを追加する。
    - 「スタンド」はカードを追加しない。
- プレイヤーは自分のカードの点数が21を超えない限り、何枚でもカードを追加できる。
- プレイヤーのカードの点数が21を超えた時点で、負けが確定する。
- プレイヤーがカードを引き終えると、ディーラーはカードの点数が17以上になるまでカードを引き続ける。
- ディーラーがカードを引き終えると勝負。カードの点数が21に近いほうの勝ち。
- プレイヤーの手持ち資金は1000ドルでゲーム開始。
- ミニマムベット（最低賭け金）は100ドルとする。
- 配当
例）100ドルをベットしていた場合
|  結果  |  払戻金  |  
| :--- | :--- |  
|  勝ち  |  200ドル  |  
|  引き分け  |  100ドル  |  
|  負け  |  0ドル  |
- プレイヤーの資金が100ドル未満になるとゲームは終了となる。
- ダブルダウン、サレンダー、スプリットのルールあり。
    - 「ダブルダウン」は賭け金を倍にして、次のカードを1枚だけ引く。最初にカードを2枚配られた後にしか選択できず、資金が足りないときは選択できない。ダブルダウンを選択した後は、手持ちのカードで勝負となる。
    - 「サレンダー」は賭け金を半分支払い、勝負を降りる。最初にカードを2枚配られた後にしか選択できない。
    - 「スプリット」は最初にカードを2枚配られた時に、2枚のカードの点数が同じだった場合に、賭け金を同額ベットし、カードを2手に分ける。それぞれ別の手持ちカードとしてゲームを続けることができる。（JとQ）や（10とK）など点数が同じであればスプリットは可能。ただし資金が不足してる場合は選択できない。

## 利用方法

Dockerの環境を使用します。
```
# イメージをビルドします。
$ docker-compose build

# コンテナをバックグラウンドで起動します。
$ docker-compose up -d

# ブラックジャックゲームの開始です！
$ docker-compose exec app php Blackjack.php
```

## 使用している技術

- PHP 8.1.6
- Docker
