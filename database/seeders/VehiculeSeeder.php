<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicule;
use App\Models\CategoriePermi;
use App\Models\pneu;
use App\Models\PneuHistorique;
use App\Models\Vidange;
use App\Models\VidangeHistorique;
use App\Models\TimingChaine;
use App\Models\TimingChaineHistorique;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuelType = array("Gasoline", "Diesel", "Electric");

        //DACIA
        $dacia  =   new Vehicule;
        $dacia->brand  =   'Dacia';
        $dacia->model  =   'Logan 2016';
        $dacia->matricule  =   '1111 | أ | 2';
        $dacia->num_chassis  =   'XXXXXXXXXXXXXXXXXX1';
        $dacia->total_km  =   120000;
        $dacia->horses  =   6;
        $dacia->number_of_tires  =   4;
        $dacia->fuel_type  =   $fuelType[array_rand($fuelType)];
        $dacia->airbag  =   1;
        $dacia->abs  =   1;
        $dacia->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $dacia->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $dacia->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $dacia->save();

        foreach(range(0, $dacia->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $dacia->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($dacia->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $dacia->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $dacia->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //DACIA


        //Duster
        $duster  =   new Vehicule;
        $duster->brand  =   'Dacia';
        $duster->model  =   'Duster 2020';
        $duster->matricule  =   '1112 | أ | 2';
        $duster->num_chassis  =   'XXXXXXXXXXXXXXXXXX2';
        $duster->total_km  =   120000;
        $duster->horses  =   6;
        $duster->number_of_tires  =   4;
        $duster->fuel_type  =   $fuelType[array_rand($fuelType)];
        $duster->airbag  =   1;
        $duster->abs  =   1;
        $duster->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $duster->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $duster->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $duster->save();

        foreach(range(0, $duster->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $duster->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($duster->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $duster->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $duster->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //Duster




        //Hyundai
        $hyundain  =   new Vehicule;
        $hyundain->brand  =   'Hyundain';
        $hyundain->model  =   'Tucson 2020';
        $hyundain->matricule  =   '1113 | أ | 2';
        $hyundain->num_chassis  =   'XXXXXXXXXXXXXXXXXX3';
        $hyundain->total_km  =   120000;
        $hyundain->horses  =   6;
        $hyundain->number_of_tires  =   4;
        $hyundain->fuel_type  =   $fuelType[array_rand($fuelType)];
        $hyundain->airbag  =   1;
        $hyundain->abs  =   1;
        $hyundain->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $hyundain->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $hyundain->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $hyundain->save();

        foreach(range(0, $hyundain->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $hyundain->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($hyundain->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $hyundain->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $hyundain->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //Hyundai








        //Honda
        $honda  =   new Vehicule;
        $honda->brand  =   'honda';
        $honda->model  =   'Accord 2020';
        $honda->matricule  =   '1114 | أ | 2';
        $honda->num_chassis  =   'XXXXXXXXXXXXXXXXXX4';
        $honda->total_km  =   120000;
        $honda->horses  =   6;
        $honda->number_of_tires  =   4;
        $honda->fuel_type  =   $fuelType[array_rand($fuelType)];
        $honda->airbag  =   1;
        $honda->abs  =   1;
        $honda->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $honda->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $honda->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $honda->save();

        foreach(range(0, $honda->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $honda->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($honda->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $honda->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $honda->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //Honda




        //volswagen
        $volswagen  =   new Vehicule;
        $volswagen->brand  =   'volswagen';
        $volswagen->model  =   'tiguan 2020';
        $volswagen->matricule  =   '1114 | أ | 2';
        $volswagen->num_chassis  =   'XXXXXXXXXXXXXXXXXX4';
        $volswagen->total_km  =   120000;
        $volswagen->horses  =   6;
        $volswagen->number_of_tires  =   4;
        $volswagen->fuel_type  =   $fuelType[array_rand($fuelType)];
        $volswagen->airbag  =   1;
        $volswagen->abs  =   1;
        $volswagen->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $volswagen->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $volswagen->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $volswagen->save();

        foreach(range(0, $volswagen->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $volswagen->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($volswagen->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $volswagen->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $volswagen->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //volswagen




        //skoda
        $skoda  =   new Vehicule;
        $skoda->brand  =   'skoda';
        $skoda->model  =   'Octavia 2020';
        $skoda->matricule  =   '1115 | أ | 2';
        $skoda->num_chassis  =   'XXXXXXXXXXXXXXXXXX5';
        $skoda->total_km  =   120000;
        $skoda->horses  =   6;
        $skoda->number_of_tires  =   4;
        $skoda->fuel_type  =   $fuelType[array_rand($fuelType)];
        $skoda->airbag  =   1;
        $skoda->abs  =   1;
        $skoda->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $skoda->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $skoda->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $skoda->save();

        foreach(range(0, $skoda->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $skoda->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($skoda->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $skoda->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $skoda->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //skoda




        //skoda_fabia
        $skoda_fabia  =   new Vehicule;
        $skoda_fabia->brand  =   'skoda';
        $skoda_fabia->model  =   'fabia 2020';
        $skoda_fabia->matricule  =   '1116 | أ | 2';
        $skoda_fabia->num_chassis  =   'XXXXXXXXXXXXXXXXXX6';
        $skoda_fabia->total_km  =   120000;
        $skoda_fabia->horses  =   6;
        $skoda_fabia->number_of_tires  =   4;
        $skoda_fabia->fuel_type  =   $fuelType[array_rand($fuelType)];
        $skoda_fabia->airbag  =   1;
        $skoda_fabia->abs  =   1;
        $skoda_fabia->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $skoda_fabia->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $skoda_fabia->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $skoda_fabia->save();

        foreach(range(0, $skoda_fabia->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $skoda_fabia->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($skoda_fabia->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $skoda_fabia->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $skoda_fabia->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //skoda_fabia


        //toyota
        $toyota  =   new Vehicule;
        $toyota->brand  =   'toyota';
        $toyota->model  =   'Yaris 2020';
        $toyota->matricule  =   '1117 | أ | 2';
        $toyota->num_chassis  =   'XXXXXXXXXXXXXXXXXX7';
        $toyota->total_km  =   120000;
        $toyota->horses  =   6;
        $toyota->number_of_tires  =   4;
        $toyota->fuel_type  =   $fuelType[array_rand($fuelType)];
        $toyota->airbag  =   1;
        $toyota->abs  =   1;
        $toyota->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $toyota->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $toyota->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $toyota->save();

        foreach(range(0, $toyota->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $toyota->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($toyota->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $toyota->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $toyota->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //toyota





        //citroen
        $citroen  =   new Vehicule;
        $citroen->brand  =   'citroen';
        $citroen->model  =   'C3 2020';
        $citroen->matricule  =   '1118 | أ | 2';
        $citroen->num_chassis  =   'XXXXXXXXXXXXXXXXXX8';
        $citroen->total_km  =   120000;
        $citroen->horses  =   6;
        $citroen->number_of_tires  =   4;
        $citroen->fuel_type  =   $fuelType[array_rand($fuelType)];
        $citroen->airbag  =   1;
        $citroen->abs  =   1;
        $citroen->inssurance_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $citroen->technicalvisite_expiration  =   \Carbon\Carbon::parse('01/01/2024');
        $citroen->permis_id   =   CategoriePermi::where('label','=', 'B')->first()->id;
        $citroen->save();

        foreach(range(0, $citroen->number_of_tires-1) as $num)
        {
            $pneu = new pneu;
            $pneu->car_id   =   $citroen->id;
            $pneu->threshold_km     =   20000;
            $pneu->tire_position    =   $num+1;
            $pneu->save();

            $historique = new PneuHistorique;
            $historique->pneu_id    =   $pneu->id;
            $historique->current_km =   intval($citroen->total_km);
            $historique->next_km_for_change =   140000;
            $historique->save();
        }

        $vidange =  new Vidange;
        $vidange->car_id            =   $citroen->id;
        $vidange->threshold_km      =   20000;
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   120000;
        $vidange_histrorique->next_km_for_drain =   140000;
        $vidange_histrorique->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $citroen->id;
        $timingChaine->threshold_km     =   20000;
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   120000;
        $timingChaine_historique->next_km_for_change    =   140000;
        $timingChaine_historique->save();
        //citroen
    }
}
