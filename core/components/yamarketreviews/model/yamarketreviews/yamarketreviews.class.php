<?php


class yaMarketReviews
{
    private $key;

    /* @var modX $modx */
    public $modx;

    public function __construct(modX &$modx, $key)
    {

        $corePath = MODX_CORE_PATH . 'components/yamarketreviews/';
        $modelPath = $corePath . 'model/';

        $this->modx =& $modx;

        $this->key = $key;

        $this->modx->addPackage('yamarketreviews', $modelPath);
    }



    public function getShopReviews($shopid, $saveTime)
    {
        if(intval($shopid) > 0){
            $this->modx->removeCollection('yaMarketReviewsShopReviews', array('expired:<=' => strtotime('now')));
            $count = $this->modx->getCount('yaMarketReviewsShopReviews', array('shopid' => $shopid));
            if($count === 0){
                $reviews = [];
                $params = [];
                $limit = 30;
                $params['count'] = $limit;
                $params = http_build_query($params);
                $url = "shops/{$shopid}/opinions?".$params;
                $response = $this->request($url);
                if($response['status'] == 'OK'){
                    $reviews = array_merge($reviews, $response['opinions']);

                    for($i = 2; $i <= $response['context']['page']['total']; $i++){
                        $params = [];
                        $params['count'] = $limit;
                        $params['page'] = $i;
                        $params = http_build_query($params);
                        $url = "shops/{$shopid}/opinions?".$params;
                        $response = $this->request($url);
                        if($response['status'] == 'OK') {
                            $reviews = array_merge($reviews, $response['opinions']);
                        }
                    }

                }
                if(count($reviews) > 0){
                    foreach($reviews as $review){
                        $q = $this->modx->newObject('yaMarketReviewsShopReviews', array(
                            'shopid' => $shopid,
                            'reviewid' => $review['id'],
                            'date' => date('d-m-Y', strtotime($review['date'])),
                            'grade' => $review['grade'],
                            'agreeCount' => $review['agreeCount'],
                            'disagreeCount' => $review['disagreeCount'],
                            'author' => $review['author']['name'],
                            'text' => $review['text'],
                            'expired' => strtotime('now + '.$saveTime)
                        ));
                        $q->save();
                    }
                }
            }

        }else{
            $this->modx->log(1, '[yaMarketReviews] - incorrect shopid');
            return;
        }
    }

    public function getProductReviews($productid, $saveTime)
    {
        if(intval($productid) > 0){
            $this->modx->removeCollection('yaMarketReviewsProductReviews', array('expired:<=' => strtotime('now')));
            $count = $this->modx->getCount('yaMarketReviewsProductReviews', array('productid' => $productid));
            if($count === 0){
                $reviews = [];
                $params = [];
                $limit = 30;
                $params['count'] = $limit;
                $params = http_build_query($params);
                $url = "models/{$productid}/opinions?".$params;
                $response = $this->request($url);
                if($response['status'] == 'OK'){
                    $reviews = array_merge($reviews, $response['opinions']);

                    for($i = 2; $i <= $response['context']['page']['total']; $i++){
                        $params = [];
                        $params['count'] = $limit;
                        $params['page'] = $i;
                        $params = http_build_query($params);
                        $url = "models/{$productid}/opinions?".$params;
                        $response = $this->request($url);
                        if($response['status'] == 'OK') {
                            $reviews = array_merge($reviews, $response['opinions']);
                        }
                    }

                }
                if(count($reviews) > 0){
                    foreach($reviews as $review){
                        $q = $this->modx->newObject('yaMarketReviewsProductReviews', array(
                            'productid' => $productid,
                            'reviewid' => $review['id'],
                            'date' => date('d-m-Y', strtotime($review['date'])),
                            'grade' => $review['grade'],
                            'agreeCount' => $review['agreeCount'],
                            'disagreeCount' => $review['disagreeCount'],
                            'author' => $review['author']['name'],
                            'text' => $review['text'],
                            'expired' => strtotime('now + '.$saveTime)
                        ));
                        $q->save();
                    }
                }
            }

        }else{
            $this->modx->log(1, '[yaMarketReviews] - incorrect productid');
            return;
        }
    }



    private function request($url)
    {
        if(empty($this->key)){
            $this->modx->log(1, '[yaMarketReviews] - missing Yandex API key');
            return;
        }
        $url = "https://api.content.market.yandex.ru/v2/".$url;
        $headers = array(
            "Host: api.content.market.yandex.ru",
            "Accept: */*",
            "Authorization: " . $this->key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($data, true);
        if($result['status'] == 'ERROR'){
            $errors = [];
            foreach($result['errors'] as $error){
                $errors[] = $error['message'];
            }
            $errors = implode(', ', $errors);
            $this->modx->log(1, '[yaMarketReviews] - '.$errors);
        }
        return $result;
    }

}