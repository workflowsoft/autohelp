<?php
/**
 * Created by PhpStorm.
 * User: PavelTropin
 * Date: 19.01.14
 * Time: 19:52
 */
class CardChecker
{
    public static function getCardSeries($cardFullNumber)
    {
        $result = null;
        preg_match("/([A-Za-z])(\d+)/", $cardFullNumber, $cardPatrs);
        if (count($cardPatrs))
        {
            $series = CardSeries::model()->find('series_type=:series and starting_number<=:number and ending_number>=:number',
                array(':series'=>$cardPatrs[1], ':number'=>$cardPatrs[2])
            );
            if (isset($series))
                $result = $series->id;
        }
        return $result;
    }

    public static function CheckCard($cardId, $orderId = null)
    {
        $result = array(
            'cardNumber'=> $cardId
        );

        $card = Card::model()->with('orders')->with('series')->find('number=:cardNumber', array(':cardNumber'=>$cardId));

        if (isset($card))
        {
            $result['id'] = $card->id;
            if (count($card->orders) && $card->orders[0]->id != $orderId)
            {
                $result['result'] = 'AlreadyUsed';
                $result['order_id'] = $card->orders[0]->id;
            }
            else
                $result['result'] = 'CanUseThis';

            if (isset($card->series))
                $result['series_id'] = $card->series->id;
        }
        else
        {
            $series_id = CardChecker::getCardSeries($cardId);
            if (is_null($series_id))
                $result['result'] = 'SeriesNotFound';
            else
            {
                $result['result'] = 'CanCreateNew';
                $result['series_id'] = $series_id;
            }
        }
        return $result;
    }
}
?>