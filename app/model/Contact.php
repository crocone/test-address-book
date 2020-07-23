<?php
/**
 * Created by: PhpStorm
 * User: shevt
 * Date: 21.07.2020
 * Time: 16:13
 */

namespace App\Model;


class Contact extends Model
{
    const TABLE = 'contact';
    const AVAILABLE_EXT = ['jpeg', 'jpg','png'];
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $contact
     * @return int
     */
    public function insert(array $contact): int
    {
        // prepared request
        $statement = $this->pdo->prepare('INSERT INTO '. self::TABLE . '(user,name,phone,image,email,comment,created_at,updated_at) 
        VALUES (:user,:name,:phone,:image,:email,:comment,:created_at,:updated_at)');
        $statement->bindValue('user', $contact['user'], \PDO::PARAM_STR);
        $statement->bindValue('name', $contact['name'], \PDO::PARAM_STR);
        $statement->bindValue('phone', $contact['phone'], \PDO::PARAM_STR);
        $statement->bindValue('image', $contact['image'] ?? 'default.png', \PDO::PARAM_STR);
        $statement->bindValue('email', $contact['email'], \PDO::PARAM_STR);
        $statement->bindValue('comment', $contact['comment'], \PDO::PARAM_STR);
        $statement->bindValue('created_at', time(), \PDO::PARAM_INT);
        $statement->bindValue('updated_at', time(), \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
        return false;
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * @param int $page
     * @param array $user
     * @param int $limit
     * @param bool $search
     * @return array
     */
    public function list(int $page = 1, array $user, int $limit = REC_BY_PAGE, $search = false)
    {
        $sql = "SELECT * FROM " . self::TABLE . ' WHERE user = :user';
        $page = $page - 1;
        $offset = $limit * $page;
        if ($search) {
            $sql .= ' AND name LIKE  (:search)';
        }
        $sql .= ' ORDER BY name ASC LIMIT :limit OFFSET :offset';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue('limit',  $limit, \PDO::PARAM_INT);
        $statement->bindParam('offset', $offset, \PDO::PARAM_INT);
        $statement->bindParam('user', $user['id'], \PDO::PARAM_INT);
        if ($search) {
            $search = '%'.$search.'%';
            $statement->bindParam('search', $search, \PDO::PARAM_STR);
        }

        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @param array $contact
     * @return bool
     */
    public function update(array $contact): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name,  `phone` = :phone,  `image` = :image,  `email` = :email,
          `comment` = :comment,`updated_at` = :updated_at  WHERE id=:id");
        $statement->bindValue('id', $contact['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $contact['name'], \PDO::PARAM_STR);
        $statement->bindValue('phone', $contact['phone'], \PDO::PARAM_STR);
        $statement->bindValue('image', $contact['image'], \PDO::PARAM_STR);
        $statement->bindValue('email', $contact['email'], \PDO::PARAM_STR);
        $statement->bindValue('comment', $contact['comment'], \PDO::PARAM_STR);
        $statement->bindValue('updated_at', time(), \PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * @param $sourceNumber
     * @return string
     */
    public function numberToText($sourceNumber)
    {
        $str = '';
        foreach (explode(' ', $sourceNumber) as $sourceNumber) {
            $sourceNumber = str_replace('+','',$sourceNumber);
            //Целое значение $sourceNumber вывести прописью по-русски
            //Максимальное значение для аругмента-числа PHP_INT_MAX
            //Максимальное значение для аругмента-строки минус/плюс 999999999999999999999999999999999999
            $smallNumbers = array( //Числа 0..999
                array('ноль'),
                array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
                array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать',
                    'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'),
                array('', '', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'),
                array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'),
                array('', 'одна', 'две')
            );
            $degrees = array(
                array('дофигальон', '', 'а', 'ов'), //обозначение для степеней больше, чем в списке
                array('тысяч', 'а', 'и', ''), //10^3
                array('миллион', '', 'а', 'ов'), //10^6
                array('миллиард', '', 'а', 'ов'), //10^9
                array('триллион', '', 'а', 'ов'), //10^12
                array('квадриллион', '', 'а', 'ов'), //10^15
                array('квинтиллион', '', 'а', 'ов'), //10^18
                array('секстиллион', '', 'а', 'ов'), //10^21
                array('септиллион', '', 'а', 'ов'), //10^24
                array('октиллион', '', 'а', 'ов'), //10^27
                array('нониллион', '', 'а', 'ов'), //10^30
                array('дециллион', '', 'а', 'ов') //10^33
            );

            if ($sourceNumber == 0) return $smallNumbers[0][0]; //Вернуть ноль
            $sign = '';
            if ($sourceNumber < 0) {
                $sign = 'минус '; //Запомнить знак, если минус
                $sourceNumber = substr($sourceNumber, 1);
            }
            $result = array(); //Массив с результатом

            //Разложение строки на тройки цифр
            $digitGroups = array_reverse(str_split(str_pad($sourceNumber, ceil(strlen($sourceNumber) / 3) * 3, '0', STR_PAD_LEFT), 3));
            foreach ($digitGroups as $key => $value) {
                $result[$key] = array();
                //Преобразование трёхзначного числа прописью по-русски
                foreach ($digit = str_split($value) as $key3 => $value3) {
                    if (!$value3) continue;
                    else {
                        switch ($key3) {
                            case 0:
                                $result[$key][] = $smallNumbers[4][$value3];
                                break;
                            case 1:
                                if ($value3 == 1) {
                                    $result[$key][] = $smallNumbers[2][$digit[2]];
                                    break 2;
                                } else $result[$key][] = $smallNumbers[3][$value3];
                                break;
                            case 2:
                                if (($key == 1) && ($value3 <= 2)) $result[$key][] = $smallNumbers[5][$value3];
                                else $result[$key][] = $smallNumbers[1][$value3];
                                break;
                        }
                    }
                }
                $value *= 1;
                if (!$degrees[$key]) $degrees[$key] = reset($degrees);

                //Учесть окончание слов для русского языка
                if ($value && $key) {
                    $index = 3;
                    if (preg_match("/^[1]$|^\\d*[0,2-9][1]$/", $value)) $index = 1; //*1, но не *11
                    else if (preg_match("/^[2-4]$|\\d*[0,2-9][2-4]$/", $value)) $index = 2; //*2-*4, но не *12-*14
                    $result[$key][] = $degrees[$key][0] . $degrees[$key][$index];
                }
                $result[$key] = implode(' ', $result[$key]);
            }

            $str .= $sign . implode(' ', array_reverse($result)).' ';
        }
        return  $str;
    }


    /**
     * @param $file
     * @return bool|string
     */
    public function saveFile($file){
        $info = pathinfo($file['name']);
        $ext = $info['extension'];
        if(!in_array($ext, self::AVAILABLE_EXT)){
            return false;
        }
        $newFileName = uniqid().'.'.$ext;
        $target = FILE_PATH.$newFileName;
        move_uploaded_file( $file['tmp_name'], $target);
        return  $newFileName;
    }

}