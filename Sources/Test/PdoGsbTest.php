<?php
require_once('..\include\class.pdogsb.inc.php');
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-10-13 at 16:59:31.
 */
class PdoGsbTest extends PHPUnit_Framework_TestCase {
    /**
     * @var PdoGsb
     */
    protected $monPdotest;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * 
     * Constructeur du test
     */
    protected function setUp() {
	$this->monPdotest = PdoGsb::getPdoGsb() ;
        PdoGsb::getPdo()->exec("SET AUTOCOMMIT OFF;");
        PdoGsb::getPdo()->beginTransaction();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     * 
     * Deconstructeur du test
     */
    protected function tearDown() {
       PdoGsb::getPdo()->rollBack();
       PdoGsb::getPdo()->exec("SET AUTOCOMMIT ON;");
    }

    /**
     * @covers PdoGsb::geInfoVisiteur
     */
    public function testgetInfosVisiteur(){
        $visiteur = array (
            "id" => "a131",
            "nom" => "Villechalane",
            "prenom" => "Louis",
            "0" => "a131",
            "1" => "Villechalane",
            "2" => "Louis"
            );
        $this->assertEquals($visiteur, $this->monPdotest->getInfosVisiteur('lvillachane', '00000'));
    }
    
    /**
    * @covers PdoGsb::getInfoComptable
    */
    public function testgetInfosComptable(){
        $comptable = array (
            "id" => "arm1",
            "nom" => "Borg",
            "prenom" => "Sébastien",
            "0" => "arm1",
            "1" => "Borg",
            "2" => "Sébastien"
            );
        $this->assertEquals($comptable, $this->monPdotest->getInfosComptable('sborg', '00000'));
    }
    
    /**
    * @covers PdoGsb::getLesFraisHorsForfait
    */
    public function testgetLesFraisHorsForfait(){
        $lesLignes = array(
            "0" => array(
                "id" => "4",
                "idVisiteur" => "a131",
                "mois" => "201409",
                "libelle" => "aa",
                "date" => "12/08/2014",
                "montant" => "1.00",
                "0" => "4",
                "1" => "a131",
                "2" => "201409",
                "3" => "aa",
                "4" => "2014-08-12",
                "5" => "1.00"
                ),
            "1" => array(
                "id" => "5",
                "idVisiteur" => "a131",
                "mois" => "201409",
                "libelle" => "aa",
                "date" => "12/08/2014",
                "montant" => "1.00",
                "0" => "5",
                "1" => "a131",
                "2" => "201409",
                "3" => "aa",
                "4" => "2014-08-12",
                "5" => "1.00"
                ),
            "2" => array(
                "id" => "6",
                "idVisiteur" => "a131",
                "mois" => "201409",
                "libelle" => "aa",
                "date" => "12/10/2014",
                "montant" => "1.00",
                "0" => "6",
                "1" => "a131",
                "2" => "201409",
                "3" => "aa",
                "4" => "2014-10-12",
                "5" => "1.00"
                ));
        $this->assertEquals($lesLignes, $this->monPdotest->getLesFraisHorsForfait('a131', '201409'));
    }

    /**
     * @cover PdoGsb::getNbjustificatifs
     */
    public function testgetNbjustificatifs() {
        $this->assertEquals(2, $this->monPdotest->getNbjustificatifs('a131', '201409'));
    }
    
    /**
     * @covers PdoGsb::getLesFraisForfait
     */
    public function testgetLesFraisForfait(){
        $lesLignes = array(
            "0" => array (
                'idfrais' => "ETP",
                "0" => "ETP",
                'libelle' => "Forfait Etape",
                "1" =>  "Forfait Etape",
                'quantite' => "1",
                "2" => "1"),
            "1" => array (
                'idfrais' => "KM",
                "0" => "KM",
                'libelle' => "Frais Kilométrique",
                "1" => "Frais Kilométrique",
                'quantite' => "12",
                "2" => "12"),
            "2" => array (
                'idfrais' => "NUI",
                "0" => "NUI",
                'libelle' => "Nuitée Hôtel",
                "1" => "Nuitée Hôtel",
                'quantite' => "2",
                "2" => "2"
                ),
            "3" =>array (
                'idfrais' => "REP",
                "0" => "REP",
                'libelle' => "Repas Restaurant",
                "1" => "Repas Restaurant",
                'quantite' => "5",
                "2" => "5")
            );
        $this->assertEquals($lesLignes, $this->monPdotest->getLesFraisForfait('a131', '201409'));
    }
    
    /**
     * @covers PdoGsb::getLesIdFrais
     */
    public function TestGetLesIdFrais(){
        $lesId = array(
            0 => array (
                'idfrais' =>  'ETP',
                0 => 'ETP'),
            1 => array (
                'idfrais' =>  'KM',
                0 => 'KM'),
            2 => array (
                'idfrais' => 'NUI',
                0 => 'NUI'),
            3 => array (
                'idfrais' => 'REP',
                0 => 'REP'));
        $this->assertEquals($lesId, $this->monPdotest->GetLesIdFrais());
    }
    
    /**
     * @covers PdoGsb::majFraisForfait
     * @todo Faire le setUp pour que le rollback fonction (enlever le AutoCommit)
     */
    public function testmajFraisForfait()
    {
        $fiche = array (
            'ETP' => '2',
            );
        $this->monPdotest->majFraisForfait("a131", "201409", $fiche);
        
        $req = "SELECT lignefraisforfait.quantite
                FROM lignefraisforfait
                WHERE lignefraisforfait.idvisiteur = 'a131'
                AND lignefraisforfait.mois = '201409'
                AND lignefraisforfait.idfraisforfait = 'ETP'";
        $res = PdoGsb::getPdo()->query($req);
        $etat = $res->fetch();

        $qte = array (
            'quantite' => '2',
            0 => '2');
        
        $this->assertEquals($qte, $etat);                
    }
    
    /**
     * @covers PdoGsb::getNom
     */
    public function testGetNom()
    {
        $this->assertEquals('Villechalane Louis', $this->monPdotest->getNom('a131'));
        $this->assertFalse('Dmin Albert' == $this->monPdotest->getNom('a001'));
    }

}
