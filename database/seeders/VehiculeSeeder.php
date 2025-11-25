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
use Carbon\Carbon;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuelTypes = ["Gasoline", "Diesel", "Electric"];
        $permisB = CategoriePermi::where(CategoriePermi::LABEL_COLUMN, '=', 'B')->first();

        //DACIA
        $dacia  =   new Vehicule;
        $dacia->setAttribute(Vehicule::BRAND_COLUMN, 'Dacia');
        $dacia->setAttribute(Vehicule::MODEL_COLUMN, 'Logan 2016');
        $dacia->setAttribute(Vehicule::MATRICULE_COLUMN, '1111 | أ | 2');
        $dacia->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX1');
        $dacia->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $dacia->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $dacia->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $dacia->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $dacia->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $dacia->setAttribute(Vehicule::ABS_COLUMN, true);
        $dacia->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $dacia->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $dacia->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
        $duster->setAttribute(Vehicule::BRAND_COLUMN, 'Dacia');
        $duster->setAttribute(Vehicule::MODEL_COLUMN, 'Duster 2020');
        $duster->setAttribute(Vehicule::MATRICULE_COLUMN, '1112 | أ | 2');
        $duster->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX2');
        $duster->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $duster->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $duster->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $duster->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $duster->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $duster->setAttribute(Vehicule::ABS_COLUMN, true);
        $duster->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $duster->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $duster->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
        $hyundain->setAttribute(Vehicule::BRAND_COLUMN, 'Hyundain');
        $hyundain->setAttribute(Vehicule::MODEL_COLUMN, 'Tucson 2020');
        $hyundain->setAttribute(Vehicule::MATRICULE_COLUMN, '1113 | أ | 2');
        $hyundain->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX3');
        $hyundain->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $hyundain->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $hyundain->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $hyundain->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $hyundain->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $hyundain->setAttribute(Vehicule::ABS_COLUMN, true);
        $hyundain->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $hyundain->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $hyundain->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
        $honda->setAttribute(Vehicule::BRAND_COLUMN, 'honda');
        $honda->setAttribute(Vehicule::MODEL_COLUMN, 'Accord 2020');
        $honda->setAttribute(Vehicule::MATRICULE_COLUMN, '1114 | أ | 2');
        $honda->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX4');
        $honda->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $honda->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $honda->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $honda->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $honda->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $honda->setAttribute(Vehicule::ABS_COLUMN, true);
        $honda->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $honda->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $honda->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
        $volswagen->setAttribute(Vehicule::BRAND_COLUMN, 'volswagen');
        $volswagen->setAttribute(Vehicule::MODEL_COLUMN, 'tiguan 2020');
        $volswagen->setAttribute(Vehicule::MATRICULE_COLUMN, '1114 | أ | 2');
        $volswagen->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX4');
        $volswagen->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $volswagen->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $volswagen->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $volswagen->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $volswagen->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $volswagen->setAttribute(Vehicule::ABS_COLUMN, true);
        $volswagen->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $volswagen->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $volswagen->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
        $skoda->setAttribute(Vehicule::BRAND_COLUMN, 'skoda');
        $skoda->setAttribute(Vehicule::MODEL_COLUMN, 'Octavia 2020');
        $skoda->setAttribute(Vehicule::MATRICULE_COLUMN, '1115 | أ | 2');
        $skoda->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX5');
        $skoda->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $skoda->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $skoda->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $skoda->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $skoda->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $skoda->setAttribute(Vehicule::ABS_COLUMN, true);
        $skoda->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $skoda->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $skoda->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
        $skoda_fabia->setAttribute(Vehicule::BRAND_COLUMN, 'skoda');
        $skoda_fabia->setAttribute(Vehicule::MODEL_COLUMN, 'fabia 2020');
        $skoda_fabia->setAttribute(Vehicule::MATRICULE_COLUMN, '1116 | أ | 2');
        $skoda_fabia->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX6');
        $skoda_fabia->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $skoda_fabia->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $skoda_fabia->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $skoda_fabia->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $skoda_fabia->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $skoda_fabia->setAttribute(Vehicule::ABS_COLUMN, true);
        $skoda_fabia->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $skoda_fabia->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $skoda_fabia->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
        $toyota->setAttribute(Vehicule::BRAND_COLUMN, 'toyota');
        $toyota->setAttribute(Vehicule::MODEL_COLUMN, 'Yaris 2020');
        $toyota->setAttribute(Vehicule::MATRICULE_COLUMN, '1117 | أ | 2');
        $toyota->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX7');
        $toyota->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $toyota->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $toyota->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $toyota->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $toyota->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $toyota->setAttribute(Vehicule::ABS_COLUMN, true);
        $toyota->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $toyota->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $toyota->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
        $citroen->setAttribute(Vehicule::BRAND_COLUMN, 'citroen');
        $citroen->setAttribute(Vehicule::MODEL_COLUMN, 'C3 2020');
        $citroen->setAttribute(Vehicule::MATRICULE_COLUMN, '1118 | أ | 2');
        $citroen->setAttribute(Vehicule::NUM_CHASSIS_COLUMN, 'XXXXXXXXXXXXXXXXXX8');
        $citroen->setAttribute(Vehicule::TOTAL_KM_COLUMN, 120000);
        $citroen->setAttribute(Vehicule::HORSES_COLUMN, 6);
        $citroen->setAttribute(Vehicule::NUMBER_OF_TIRES_COLUMN, 4);
        $citroen->setAttribute(Vehicule::FUEL_TYPE_COLUMN, $fuelTypes[array_rand($fuelTypes)]);
        $citroen->setAttribute(Vehicule::AIRBAG_COLUMN, true);
        $citroen->setAttribute(Vehicule::ABS_COLUMN, true);
        $citroen->setAttribute(Vehicule::INSSURANCE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $citroen->setAttribute(Vehicule::TECHNICALVISITE_EXPIRATION_COLUMN, Carbon::parse('01/01/2024'));
        $citroen->setAttribute(Vehicule::PERMIS_ID_COLUMN, $permisB->getId());
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
