<?php
namespace App\Services;


use App\Models\Cotrudnik;
use App\Models\Drive;
use App\Models\Firma;
use App\Models\Reportdrive;
use Carbon\Carbon;
use DateTime;
use setasign\Fpdi\Fpdi;
use Codedge\Fpdf\Fpdf\Fpdf;


class PrintService{


    /**
     * Форма печати
     * @param $data
     * @param $datastart
     * @param $datastop
     * @param bool $save
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\Filter\FilterException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function printPdf($data,$datastart,$datastop,$save=false){

        $months = array( 1 => 'января' ,
                            'февраля' ,
                            'марта' ,
                            'апреля' ,
                            'мая' ,
                            'июня' ,
                            'июля' ,
                            'августа' ,
                            'сентября' ,
                            'октября' ,
                            'ноября' ,
                            'декабря' );


        $datetime1 = new DateTime($datastart);

        $datetime2 = new DateTime($datastop);

        $difference = $datetime1->diff($datetime2);
        $countdate=$difference->days;
        //$dataFor=date('Y-m-d',strtotime($datastart));
        $dataFor = new DateTime($datastart);
        //dump($dataFor->format('Y-m-d'));
        //$dataFor->modify("+24 hours");
        //dump($dataFor->format('Y-m-d'));
        //$dataFor->modify("+24 hours");
        //dump($dataFor->format('Y-m-d'));
        //$dataFor=date("Y-m-d",strtotime($datastart));
      //  dump(gettype($dataFor));
        $data_=strtotime($dataFor->format('Y-m-d'));

        // Экземпляр класса
        $pdf = new Fpdi('P','mm','A5');
        $sFIOmex=Cotrudnik::find(1);
        $sFIOmex=$sFIOmex->fio;
        $sFIOdes=Cotrudnik::find(2);
        $sFIOdes=$sFIOdes->fio;
        $sFIOdri=$data->fiosmal;
        $sFIOkas=Cotrudnik::find(5);
        $sFIOkas=$sFIOkas->fio;
        $sFIOmed=Cotrudnik::find(4);
        $sFIOmed=$sFIOmed->fio;
        $datafirm=Firma::find($data->firmaid);
        $namefirma=$datafirm->name.' ОГРН '.$datafirm->nomerorganiz;
        $addressfirm=$datafirm->address;

        $pdf->SetTitle($data->fiosmal."_".$data->gosnomer."_".$datastart."_".$datastop,true);
        //
        //dump($countdate);
        for($i=0;$i<=$countdate;$i++){



            $year_=date("Y",$data_);
            $mont_=date("m",$data_);
            $year1_=date("y",$data_);
            $deay_=date("d",$data_);
            $month_=$months[date( 'n',$data_ )];
            // добовляем страницу
            $pdf->AddPage();

            // показываем страницу
            $pdf->AddFont('Arial','','arial.php');
            // устанавливаем шрифт Ариал
            $pdf->SetFont('Arial');
            // получаем шаблон 1 страницы
            $pdf->setSourceFile(storage_path("temp_list1.pdf"));
            // импортируем 1 страницу
            $tplIdx = $pdf -> importPage(1);
            // вставвляем слой с точки 0 и 0 и увеличиваем на 155 процентов
            $pdf -> useImportedPage($tplIdx,0,-5,150);
            //
            //****************** Вставляем данные сверху
            $pdf->SetFontSize(12); // размер текста
            $pdf->SetXY(62,17);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$mont_.$year1_));
            $pdf->SetXY(78,17);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$deay_));
            $pdf->SetFontSize(10);
            $pdf->SetXY(44,24);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$deay_));
            $pdf->SetXY(55,24);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$month_));
            $pdf->SetXY(72,24);



            $pdf->Write(0,iconv('utf-8', 'windows-1251',$year_));
            $pdf->SetFontSize(7); // размер текста

            $pdf->SetXY(119,46.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->garajnomer));
            $pdf->SetXY(117,49.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->tabelnomer));

            $pdf->SetXY(30,30);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$namefirma));
            $pdf->SetXY(30,35);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$addressfirm));
            $pdf->SetXY(34,43.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->avto));
            $pdf->SetXY(49,46.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->gosnomer));  //тут берем с базы
            $pdf->SetXY(26,49.5);
            //$pdf->Write(0,iconv('utf-8', 'windows-1251',"АВЕТИСЯН РАДИОН ГУРГЕНОВИЧ"));  //тут берем с базы
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->name));  //тут берем с базы
            $pdf->SetXY(37,55);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->ydost1.$data->ydost2)); //тут берем с базы
            $pdf->SetXY(85,60.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer1));//тут берем с базы
            $pdf->SetXY(112,60.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer2));  //тут берем с базы
            $pdf->SetXY(125,60.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer3)); //тут берем с базы
            $pdf->SetFontSize(6);
            $pdf->SetXY(117,71);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы
            $pdf->SetFontSize(6);
            $pdf->SetXY(41,83);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOdes)); //тут берем с базы
            $pdf->SetXY(79,83);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы

            $pdf->SetFontSize(5); // размер текста
            $pdf->SetXY(117,83);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->fiosmal)); //тут берем с базы
            $pdf->SetFontSize(6); // размер текста
            $pdf->SetXY(67,138);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы
            $pdf->SetXY(115,138);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOkas)); //тут берем с базы
            $pdf->Line(11,189.3,135,189.3);
            // добовляем страницу
            $pdf->AddPage();
            // получаем шаблон 2 страницы
            $pdf->setSourceFile(storage_path("temp_list2.pdf"));
            // импортируем страницу 2
            $tplIdx = $pdf -> importPage(1);
            // вставляем импортиурем шаблон
            //$pdf -> useImportedPage($tplIdx,0,0,155);
            $pdf->useTemplate($tplIdx, 0, -5, 148, 220, true);

            $pdf->SetFontSize(6);
            $pdf->SetXY(47,165);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы

            $pdf->SetFontSize(5);
            $pdf->SetXY(116.5,153);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->fiosmal)); //тут берем с базы
            $pdf->SetFontSize(6);
            $pdf->SetXY(117,168);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы
            $pdf->SetXY(117,177);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы
            $pdf->SetXY(50,195);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmed)); //тут берем с базы
            $pdf->SetXY(120,195);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmed)); //тут берем с базы

            $pdf->SetFontSize(8);
            $pdf->SetXY(11,189);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$dataFor->format('d/m/Y'))); //тут берем с базы
            $pdf->SetXY(80,189);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$dataFor->format('d/m/Y'))); //тут берем с базы

            $pdf->SetXY(11,155);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$dataFor->format('d/m/Y'))); //тут берем с базы


            $dataFor->modify("+24 hours");
            $data_=strtotime($dataFor->format('Y-m-d'));

            $pdf->Line(8.85,20.3,8.85,189.3);

           // $data_=$data_+1;
        }
        $namepdf="Алексей";
        //показываем страницу
        $pdf->Output($data->fiosmal."_".$data->gosnomer."_".$datastart."_".$datastop.".pdf",'D',true);
    }

    public function printPdfNewForm($data,$datastart,$datastop,$save=false){

        //   dd($datastop);
        if(is_null($datastart)){
            $datastart=Date('Y-m-01');
        }

        if(is_null($datastop)){
            //текущая дата в Unix формате
            $currentDate = time();
            //подставляем текущую дату и параметр
            //последнего дня текущего месяца "t" в функцию date()
            $lastDay = date('t', $currentDate);
            $datastop=Date('Y-m-'.$lastDay);
        }


        $months = array( 1 => 'января' ,
            'февраля' ,
            'марта' ,
            'апреля' ,
            'мая' ,
            'июня' ,
            'июля' ,
            'августа' ,
            'сентября' ,
            'октября' ,
            'ноября' ,
            'декабря' );
        // дата
        $datetime1 = new DateTime($datastart);
        $datetime2 = new DateTime($datastop);
        // кол-во дней между интервалми
        $difference = $datetime1->diff($datetime2);
        // кол-во днкй
        $countdate=$difference->days;

        //с какой даты наченать
        $dataFor = new DateTime($datastart);
        // получаем дату
        $data_=strtotime($dataFor->format('Y-m-d'));

        // Экземпляр класса
        $pdf = new Fpdi('P','mm','A5');
        // вывыодим ФИО сотрудников
        $sFIOmex=Cotrudnik::find(1);
        $sFIOmex=$sFIOmex->fio;
        $sFIOdes=Cotrudnik::find(2);
        $sFIOdes=$sFIOdes->fio;
        $sFIOdri=$data->fiosmal;
        $sFIOkas=Cotrudnik::find(5);
        $sFIOkas=$sFIOkas->fio;
        $sFIOmed=Cotrudnik::find(4);
        $sFIOmed=$sFIOmed->fio;
        $datafirm=Firma::find($data->firmaid);
        $namefirma1=$datafirm->name;
        $namefirma2=$datafirm->nomerorganiz;
        $addressfirm=$datafirm->address;
        // название текста
        $pdf->SetTitle($data->fiosmal."_".$data->gosnomer."_".$datastart."_".$datastop,true);
        //
        //dump($countdate);
        for($i=0;$i<=$countdate;$i++){
            // год
            $year_=date("Y",$data_);
            // месяц
            $mont_=date("m",$data_);
            // год
            $year1_=date("y",$data_);
            // денб
            $deay_=date("d",$data_);
            // месяц
            $month_=$months[date( 'n',$data_ )];
            // добовляем страницу
            $pdf->AddPage();
            // показываем страницу
            $pdf->AddFont('Arial','','arial.php');
            // устанавливаем шрифт Ариал
            $pdf->SetFont('Arial');
            // получаем шаблон 1 страницы
            $pdf->setSourceFile(storage_path("request.pdf"));
            // импортируем 1 страницу
            $tplIdx = $pdf -> importPage(1);
            // вставвляем слой с точки 0 и 0 и увеличиваем на 155 процентов
            $pdf -> useImportedPage($tplIdx,0,3,145);
            //
            //****************** Вставляем данные сверху
            $pdf->SetFontSize(12); // размер текста
            $pdf->SetXY(85,11.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',"10".$deay_));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(64.5,20);
            $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                            $deay_));
            $pdf->SetXY(71.5,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $month_));
            $pdf->SetXY(90,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "20"));

            $pdf->SetXY(64.5+35,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_));
            $pdf->SetXY(71.5+35,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $month_));
            $pdf->SetXY(91+35,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "20"));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(25,34);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$namefirma1));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(25,39);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$namefirma2));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(79,39);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',"11111"));

            $pdf->SetXY(15,44);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$addressfirm));

            $pdf->SetXY(12,61);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->avto));

            $pdf->SetXY(109,61);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->gosnomer));

            $pdf->SetFontSize(7); // размер текста
            $pdf->SetXY(22,66.5);
            $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                            "ЛЕГКОВОЙ АВТОМОБИЛЬ (B)"));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(82,66.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer1));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(110,66.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer2));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(121.5,66.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer3));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(114,76);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(19,86);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex));

            $pdf->SetFontSize(8);
            $pdf->SetXY(44,86);
            $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                $deay_.".".$mont_.".".$year_." 05час15мин"));

            $pdf->SetFontSize(9);
            $pdf->SetXY(11,101);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->name));  //тут берем с базы
            $pdf->SetXY(95,101);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->ydost1.$data->ydost2));
            $pdf->SetXY(134,101);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',"B"));

            $pdf->SetXY(74,123);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmed));

            $pdf->SetFontSize(8);
            $pdf->SetXY(108,120);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_.".".$mont_.".".$year_));
            $pdf->SetXY(108,123);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                " 05час22мин"));




            $pdf->SetFontSize(7);
            $pdf->SetXY(39,162);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы

            $pdf->SetFontSize(8);
            $pdf->SetXY(70,159);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_.".".$mont_.".".$year_));
            $pdf->SetXY(69,162);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                " 05час34мин"));





            $pdf->SetFontSize(7);
            $pdf->SetXY(39,174);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->fiosmal)); //тут берем с базы

            $pdf->SetFontSize(8);
            $pdf->SetXY(70,171);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_.".".$mont_.".".$year_));
            $pdf->SetXY(70,174);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                " 05час37мин"));

            $pdf->SetXY(26,182);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                " 05час42мин"));

            //*********************************************************
            // добовляем страницу*******************************
            //*********************************************************
            $dataFor->modify("+24 hours");
            $datanext_=strtotime($dataFor->format('Y-m-d'));

            // год
            $year1_=date("Y",$datanext_);
            // месяц
            $mont1_=date("m",$datanext_);
            // год
            $year1_=date("y",$datanext_);
            // денб
            $deay1_=date("d",$datanext_);
            // месяц
            $month1_=$months[date( 'n',$datanext_ )];



            $pdf->AddPage();
            // получаем шаблон 1 страницы
            $pdf->setSourceFile(storage_path("request.pdf"));
            // импортируем 1 страницу
            $tplIdx = $pdf -> importPage(1);
            // вставвляем слой с точки 0 и 0 и увеличиваем на 155 процентов
            $pdf -> useImportedPage($tplIdx,0,3,145);
            //
            //****************** Вставляем данные сверху
            $pdf->SetFontSize(12); // размер текста
            $pdf->SetXY(86,11.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',"20".$deay_));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(64.5,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_));
            $pdf->SetXY(71.5,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $month_));
            $pdf->SetXY(90,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "20"));

            $pdf->SetXY(64.5+35,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay1_));
            $pdf->SetXY(71.5+35,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $month1_));
            $pdf->SetXY(91+35,20);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "20"));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(25,34);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$namefirma1));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(25,39);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$namefirma2));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(79,39);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',"11111"));

            $pdf->SetXY(15,44);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$addressfirm));

            $pdf->SetXY(12,61);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->avto));

            $pdf->SetXY(109,61);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->gosnomer));

            $pdf->SetFontSize(7); // размер текста
            $pdf->SetXY(22,66.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "ЛЕГКОВОЙ АВТОМОБИЛЬ (В)"));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(82,66.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer1));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(110,66.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer2));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(121.5,66.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer3));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(114,76);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(19,86);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex));

            $pdf->SetFontSize(8);
            $pdf->SetXY(44,86);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_.".".$mont_.".".$year_." 16час15мин"));

            $pdf->SetFontSize(9);
            $pdf->SetXY(11,101);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->name));  //тут берем с базы
            $pdf->SetXY(95,101);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->ydost1.$data->ydost2));
            $pdf->SetXY(134,101);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',"B"));

            $pdf->SetXY(74,123);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmed));

            $pdf->SetFontSize(8);
            $pdf->SetXY(108,119);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_.".".$mont_.".".$year_));
            $pdf->SetXY(108,123);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                " 16час22мин"));




            $pdf->SetFontSize(7);
            $pdf->SetXY(39,162);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы

            $pdf->SetFontSize(8);
            $pdf->SetXY(70,158);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_.".".$mont_.".".$year_));
            $pdf->SetXY(69,162);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                " 16час34мин"));





            $pdf->SetFontSize(7);
            $pdf->SetXY(39,174);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->fiosmal)); //тут берем с базы

            $pdf->SetFontSize(8);
            $pdf->SetXY(70,170);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $deay_.".".$mont_.".".$year_));
            $pdf->SetXY(70,174);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                " 16час37мин"));

            $pdf->SetXY(26,182);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                " 16час42мин"));


            $data_=strtotime($dataFor->format('Y-m-d'));
            $data_=$data_+1;
        }
        //dd('dsdsa');
        //предлогаем сохранить файл
        $pdf->Output($data->fiosmal."_".$data->gosnomer."_".$datastart."_".$datastop.".pdf",'I',true);
    }

    public function printPdfNewFormA4($data,$datastart,$datastop,$save=false){
      //  dd($data);
        if(is_null($datastart)){
            $datastart=Date('Y-m-'.date('d'));
        }

        if(is_null($datastop)){
            $dateEnd = new DateTime($datastart);
            $dateEnd->modify('last day of this month');
            $datastop=Date($dateEnd->format('Y-m-d'));
        }
        if($datastart>$datastop){
            $dateEnd = new DateTime($datastart);
            $dateEnd->modify('last day of this month');
            $datastop=Date($dateEnd->format('Y-m-d'));
        }

        $months = array( 1 => 'января' ,
            'февраля' ,
            'марта' ,
            'апреля' ,
            'мая' ,
            'июня' ,
            'июля' ,
            'августа' ,
            'сентября' ,
            'октября' ,
            'ноября' ,
            'декабря' );
        // дата
        $datetime1 = new DateTime($datastart);
        $datetime2 = new DateTime($datastop);
        // кол-во дней между интервалми
        $difference = $datetime1->diff($datetime2);

        //dd($datetime2);
        // кол-во днкй
        $countdate=$difference->days;

        //с какой даты наченать
        $dataFor = new DateTime($datastart);
        // получаем дату
        $data_=strtotime($dataFor->format('Y-m-d'));

        // Экземпляр класса
        $pdf = new Fpdi('L','mm','A4');
        // вывыодим ФИО сотрудников
        $sFIOmex=Cotrudnik::find(1);
        $sFIOmex=$sFIOmex->fio;
        $sFIOdes=Cotrudnik::find(2);
        $sFIOdes=$sFIOdes->fio;
        $sFIOdri=$data->fiosmal;
        $sFIOkas=Cotrudnik::find(5);
        $sFIOkas=$sFIOkas->fio;
        $sFIOmed=Cotrudnik::find(4);
        $sFIOmed=$sFIOmed->fio;
        $datafirm=Firma::find($data->firmaid);
        $namefirma1=$datafirm->name;
        $namefirma2=$datafirm->nomerorganiz;
        $addressfirm=$datafirm->address;
        // название текста
        $pdf->SetTitle($data->fiosmal."_".$data->gosnomer."_".$datastart."_".$datastop,true);
        //
        //dump($countdate);

        $arrayData=array();
        for($i=0;$i<=$countdate;$i++) {
            // год
            $year1_ = date("y", $data_);
            // денб
            $deay_ = date("d", $data_);
            // месяц
            $month_ = $months[date('n', $data_)];
            /**
             * для листа 10**
             */
            $arrayData[]=['number'=>"10".$deay_,
                            'd1'=>$deay_,
                            'm1'=>$month_,
                            'y1'=>$year1_,
                            'd2'=>$deay_,
                            'm2'=>$month_,
                            'y2'=>$year1_,
                            'type'=>1,
                            ];
            /**
             * для листа 20**
             */
            $dataFor->modify("+24 hours");
            $datanext_=strtotime($dataFor->format('Y-m-d'));

            // год
            $year1_=date("y",$datanext_);
            // денб
            $deay1_=date("d",$datanext_);
            // месяц
            $month1_=$months[date( 'n',$datanext_ )];
            $arrayData[]=['number'=>"20".$deay_,
                            'd1'=>$deay_,
                            'm1'=>$month_,
                            'y1'=>$year1_,
                            'd2'=>$deay1_,
                            'm2'=>$month1_,
                            'y2'=>$year1_,
                            'type'=>2,
                ];
            //$dataFor->modify("+24 hours");
            $data_=strtotime($dataFor->format('Y-m-d'));
            $data_=$data_+1;
        }
        //dd($arrayData);
        for($i=0;$i<=$countdate;$i++) {
            // добовляем страницу
            $pdf->AddPage();
            // показываем страницу
            $pdf->AddFont('Arial','','arial.php');
            // устанавливаем шрифт Ариал
            $pdf->SetFont('Arial');
            // получаем шаблон 1 страницы
            $pdf->setSourceFile(storage_path("Doc1.pdf"));
            // импортируем 1 страницу
            $tplIdx = $pdf -> importPage(1);
            // вставвляем слой с точки 0 и 0 и увеличиваем на 155 процентов
            $pdf -> useImportedPage($tplIdx,-2,3,300);
            $pdf->SetFontSize(7);
            $pdf->SetXY(10,7.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->fiosmal));
            $pdf->SetFontSize(7);
            $pdf->SetXY(10+147,7.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->fiosmal));


            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(92,17.5);
            $pdf->Write(0,iconv('utf-8',
                                'windows-1251',
                                $arrayData[$i]['number']));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(91+147,17);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i+$countdate+1]['number']));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(69,25);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i]['d1']));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(78,25);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i]['m1']));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(94.5,25);
            if(  $arrayData[$i]['m1']=="декабря"){
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "20"));
            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    "21"));
            }

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(69+147,24.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i+$countdate+1]['d1']));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(78+147,24.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i+$countdate+1]['m1']));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(94.5+147,24.5);
            if($arrayData[$i+$countdate+1]['m2']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                  "20"));
            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    "21"));
            }




            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(104,25);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i]['d2']));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(111,25);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i]['m2']));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(129,25);

            if($arrayData[$i]['m2']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                   "20"));
            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    "21"));
            }


            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(104+147,24.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i+$countdate+1]['d2']));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(110+147,24.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $arrayData[$i+$countdate+1]['m2']));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(128+147,24.5);

            if($arrayData[$i+$countdate+1]['m2']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    "20"));
            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    "21"));
            }



            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(28,38);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $namefirma1));
            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(28+147,38);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $namefirma1));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(29,43.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $namefirma2));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(29+147,43);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $namefirma2));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(84,43.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "+74957920972"));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(84+147,43);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "+74957920972"));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(19,48.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $addressfirm));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(19+147,48.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                $addressfirm));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(31,65);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->avto));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(31+147,64.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->avto));

            $pdf->SetXY(112,65);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->gosnomer));

            $pdf->SetXY(112+145,64.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->gosnomer));

            $pdf->SetFontSize(7); // размер текста
            $pdf->SetXY(29,70);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "ЛЕГКОВОЙ АВТОМОБИЛЬ (B)"));

            $pdf->SetFontSize(7); // размер текста
            $pdf->SetXY(29+147,69.5);
            $pdf->Write(0,iconv('utf-8',
                'windows-1251',
                "ЛЕГКОВОЙ АВТОМОБИЛЬ (B)"));


            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(86,70);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer1));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(114,70);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer2));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(124,70);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer3));

            $pdf->SetFontSize(9); // размер текста
                $pdf->SetXY(86+147,69.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer1));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(113+147,69.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer2));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(124+147,69.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->regnomer3));


            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(118,83);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex));


            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(25,94);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex));

            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(118+147,83);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex));


            $pdf->SetFontSize(9); // размер текста
            $pdf->SetXY(25+147,93.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex));

            $pdf->SetFontSize(8);


            //dump($i);

            if($arrayData[$i]['type']==1){
                $pdf->SetXY(49,91.5);


                if($arrayData[$i]['m1']=="декабря"){
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2020"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2021"));
                }






                $pdf->SetXY(49,94.5);
                if($data->setTime>0){
                    $year1__ = date("Y", $data_);
                    $dataStart1=
                        Carbon::create(
                            $year1__,
                            date('n', $data_),
                            date("d", $data_),
                            $data->hStart,
                            $data->mStart,
                            0,
                            'America/Toronto');
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 15мин"));
                }
            }else{
                $pdf->SetXY(49,91.5);
                if($arrayData[$i]['m1']=="декабря"){
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2020"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2021"));
                }



                $pdf->SetXY(49,94.5);
                if($data->setTime>0){
                    $year1__ = date("Y", $data_);
                    $dataStart2=
                        Carbon::create(
                            $year1__,
                            date('n', $data_),
                            date("d", $data_),
                            $data->hEnd,
                            $data->mEnd,
                            0,
                            'America/Toronto');
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 15мин"));
                }
            }

            $pdf->SetFontSize(8);
            /*dump($arrayData);
            dump($i);
            dump($countdate);
            dd($i+$countdate+1);*/
            if($arrayData[$i+$countdate+1]['type']==1){
                $pdf->SetXY(49+147,91.5);
                if($arrayData[$i+$countdate+1]['m1']=="декабря"){
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 20".$arrayData[$i+$countdate+1]['y1']));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 20".$arrayData[$i+$countdate+1]['y1']));
                }



                $pdf->SetXY(49+147,94.5);
                if($data->setTime>0){
                    $year1__ = date("Y", $data_);
                    $dataStart1=
                        Carbon::create(
                            $year1__,
                            date('n', $data_),
                            date("d", $data_),
                            $data->hStart,
                            $data->mStart,
                            0,
                            'America/Toronto');

                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 15мин"));
                }
            }else{

                $pdf->SetXY(49+147,91);
                if($arrayData[$i+$countdate+1]['m1']=="декабря"){
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2020"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2021"));
                }


                $pdf->SetXY(49+147,93.5);
                if($data->setTime>0){
                    $year1__ = date("Y", $data_);
                    $dataStart2=
                        Carbon::create(
                            $year1__,
                            date('n', $data_),
                            date("d", $data_),
                            $data->hEnd,
                            $data->mEnd,
                            0,
                            'America/Toronto');
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 15мин"));
                }


            }

            $pdf->SetFontSize(9);
            $pdf->SetXY(19,108.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->name));  //тут берем с базы
            $pdf->SetXY(101,108.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->ydost1.$data->ydost2));
            $pdf->SetXY(138,108.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',"B"));

            $pdf->SetFontSize(9);
            $pdf->SetXY(19+147,108);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->name));  //тут берем с базы
            $pdf->SetXY(101+147,108);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->ydost1.$data->ydost2));
            $pdf->SetXY(135.5+147,108);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',"B"));

            $pdf->SetFontSize(9);
            $pdf->SetXY(79,126);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmed));

            $pdf->SetFontSize(7.5);

            if($arrayData[$i]['type']==1){
                $pdf->SetXY(110,123.5);
                if($arrayData[$i]['m1']=="декабря"){
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2020"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2021"));
                }


                $pdf->SetXY(112,126.5);
                if($data->setTime>0){
                    $dataStart1->addMinute(7);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 22мин"));
                }


            }else{
                $pdf->SetXY(110,123.5);
                if($arrayData[$i]['m1']=="декабря"){
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2020"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2021"));
                }



                $pdf->SetXY(112,126.5);

                if($data->setTime>0){
                    $dataStart2->addMinute(7);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 22мин"));
                }
            }



            $pdf->SetFontSize(9);
            $pdf->SetXY(78+147,125.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmed));



            $pdf->SetFontSize(7.5);

            if($arrayData[$i+$countdate+1]['type']==1){
                $pdf->SetXY(110+147,121.5);

                if($arrayData[$i+$countdate+1]['m1']=="декабря"){
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2020"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2021"));
                }


                $pdf->SetXY(110+147,125.5);

                if($data->setTime>0){
                  //  $dataStart1->subMinute(6);
                    if($arrayData[$i+$countdate+1]['type']!=$arrayData[$i]['type'])
                        $dataStart1->addMinute(7);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 22мин"));
                }
            }else{
                $pdf->SetXY(110+147,122.5);
                if($arrayData[$i+$countdate+1]['m1']=="декабря"){
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2020"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2021"));
                }
                $pdf->SetXY(110+147,125.5);
                if($data->setTime>0){
                    if($arrayData[$i+$countdate+1]['type']!=$arrayData[$i]['type'])
                        $dataStart2->addMinute(7);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 22мин"));
                }
            }

            $pdf->SetFontSize(9);
            $pdf->SetXY(45,160);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы


            $pdf->SetFontSize(9);
            $pdf->SetXY(45+147,159.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$sFIOmex)); //тут берем с базы




            $pdf->SetFontSize(7.5);
            $pdf->SetXY(77,157.5);
            if($arrayData[$i]['m1']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2020"));
            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2021"));
            }


            $pdf->SetXY(77,160.5);
            if($arrayData[$i]['type']==1){
                if($data->setTime>0){
                    $dataStart1->addMinute(12);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 34мин"));
                }
            }else{
                if($data->setTime>0){
                    $dataStart2->addMinute(12);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 34мин"));
                }
            }



            $pdf->SetFontSize(7.5);
            $pdf->SetXY(77+147,157);

            if($arrayData[$i+$countdate+1]['m1']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2020"));
            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2021"));
            }


            $pdf->SetXY(77+147,160);
            if($arrayData[$i+$countdate+1]['type']==1){
                if($data->setTime>0){
                    if($arrayData[$i+$countdate+1]['type']!=$arrayData[$i]['type'])
                        $dataStart1->addMinute(12);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 34мин"));
                }
            }else{
                if($data->setTime>0){
                    if($arrayData[$i+$countdate+1]['type']!=$arrayData[$i]['type'])
                        $dataStart2->addMinute(12);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 34мин"));
                }
            }


            $pdf->SetFontSize(7);
            $pdf->SetXY(46,171.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->fiosmal)); //тут берем с базы
            $pdf->SetFontSize(7);
            $pdf->SetXY(46+147,170.5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->fiosmal)); //тут берем с базы

            $pdf->SetFontSize(7.5);
            $pdf->SetXY(76,169);
            if($arrayData[$i]['m1']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2020"));
            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2021"));
            }


            $pdf->SetXY(76,171.5);
            if($arrayData[$i]['type']==1){
                if($data->setTime>0){
                    $dataStart1->addMinute(3);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 37мин"));
                }
            }else{
                if($data->setTime>0){
                    $dataStart2->addMinute(3);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 37мин"));
                }
            }

            $pdf->SetFontSize(7.5);
            $pdf->SetXY(76+147,168.5);
            if($arrayData[$i+$countdate+1]['m1']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2020"));

            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2021"));

            }

            $pdf->SetXY(76+147,171);
            if($arrayData[$i+$countdate+1]['type']==1){
                if($data->setTime>0){
                    if($arrayData[$i+$countdate+1]['type']!=$arrayData[$i]['type'])
                        $dataStart1->addMinute(3);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 37мин"));
                }
            }else{
                if($data->setTime>0){
                    if($arrayData[$i+$countdate+1]['type']!=$arrayData[$i]['type'])
                       $dataStart2->addMinute(3);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 37мин"));
                }
            }


            $pdf->SetFontSize(7.5);
            $pdf->SetXY(31.5,177);

            if($arrayData[$i]['m1']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2020"));

            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i]['d1']." ".$arrayData[$i]['m1']." 2021"));

            }




            $pdf->SetXY(31,179.5);
            if($arrayData[$i]['type']==1){
                if($data->setTime>0){
                    $dataStart1->addMinute(4);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 41мин"));
                }


            }else{
                if($data->setTime>0){
                    $dataStart2->addMinute(4);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 41мин"));
                }
            }


            $pdf->SetFontSize(7.5);
            $pdf->SetXY(31+147,176.5);
            if($arrayData[$i+$countdate+1]['m1']=="декабря"){
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2020"));


            }else{
                $pdf->Write(0,iconv('utf-8',
                    'windows-1251',
                    $arrayData[$i+$countdate+1]['d1']." ".$arrayData[$i+$countdate+1]['m1']." 2021"));
            }


            $pdf->SetXY(31+147,179);
            if($arrayData[$i+$countdate+1]['type']==1){
                if($data->setTime>0){
                    if($arrayData[$i+$countdate+1]['type']!=$arrayData[$i]['type'])
                    $dataStart1->addMinute(4);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart1->hour>0 && $dataStart1->hour<=9?'0'.$dataStart1->hour:$dataStart1->hour)."час".
                        ($dataStart1->minute>0 && $dataStart1->minute<=9?'0'.$dataStart1->minute:$dataStart1->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 05час 41мин"));
                }
            }else{
                if($data->setTime>0){
                    if($arrayData[$i+$countdate+1]['type']!=$arrayData[$i]['type'])
                      $dataStart2->addMinute(4);
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        ($dataStart2->hour>0 && $dataStart2->hour<=9?'0'.$dataStart2->hour:$dataStart2->hour)."час".
                        ($dataStart2->minute>0 && $dataStart2->minute<=9?'0'.$dataStart2->minute:$dataStart2    ->minute)."мин"));
                }else{
                    $pdf->Write(0,iconv('utf-8',
                        'windows-1251',
                        " 16час 41мин"));
                }
            }


        }

        //предлогаем сохранить файл
        $pdf->Output($data->fiosmal."_".$data->gosnomer."_".$datastart."_".$datastop.".pdf",'I',true);
    }

    /**
     * Записываем когда закручивали данные
     * @param $data
     * @param $datastart
     * @param $datastop
     */
    public function InsertLogPrint($data,$datastart,$datastop){
        if(is_null($datastart)){
            $datastart=Date('Y-m-'.date('d'));
        }

        if(is_null($datastop)){
            $dateEnd = new DateTime($datastart);
            $dateEnd->modify('last day of this month');
            $datastop=Date($dateEnd->format('Y-m-d'));
        }
        if($datastart>$datastop){
            $dateEnd = new DateTime($datastart);
            $dateEnd->modify('last day of this month');
            $datastop=Date($dateEnd->format('Y-m-d'));
        }
       // dump($datastart);
       // dd($datastop);
        // модель
        $models=new Reportdrive();
        // записываем данные
        $models->idrecord=$data->id;
        $models->datastart=$datastart;
        $models->dataend=$datastop;
        // записываем данные
        $models->save();
    }

    public function PrintLogId($id){

        $countdata=Reportdrive::where('idrecord', $id)->count();
        if($countdata==0){
            return 0;
        }
        $datas= Reportdrive::where('idrecord', $id)->get();

        $datadrive=Drive::find($datas[0]->idrecord);
        //  dump($datadrive);
        // Экземпляр класса
        $pdf = new Fpdi('P','mm','A4');
        // добовляем страницу
        $pdf->AddPage();

        // показываем страницу
        $pdf->AddFont('Arial','','arial.php');
        // устанавливаем шрифт Ариал
        $pdf->SetFont('Arial');

        $pdf->SetFontSize(14);
        $pdf->SetXY(10,10);
        $pdf->Write(0,iconv('utf-8', 'windows-1251',"Ф.И.О.(водителя) - ".$datadrive->driverfio)); //тут берем с базы
        $pdf->SetXY(10,16);
        $pdf->Write(0,iconv('utf-8', 'windows-1251',"Авто - ".$datadrive->avto));
        $pdf->SetXY(10,22);
        $pdf->Write(0,iconv('utf-8', 'windows-1251',"Гос.номер - ".$datadrive->gosnomer));
        $pdf->SetXY(10,28);
        $pdf->Write(0,iconv('utf-8', 'windows-1251',"Дата формирование"));
        $pdf->SetXY(80,28);
        $pdf->Write(0,iconv('utf-8', 'windows-1251',"Дата с"));
        $pdf->SetXY(120,28);
        $pdf->Write(0,iconv('utf-8', 'windows-1251',"Дата по"));
        $i=0;
        $pdf->SetFontSize(9);
        foreach ($datas as $data)
        {
            $pdf->SetXY(10,35+$i*5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->created_at));
            $pdf->SetXY(80,35+$i*5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->datastart));
            $pdf->SetXY(120,35+$i*5);
            $pdf->Write(0,iconv('utf-8', 'windows-1251',$data->dataend));
            $i++;
        }
        //показываем страницу
        $pdf->Output("",'D',true);
    }
}
