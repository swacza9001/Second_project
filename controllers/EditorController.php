<?php

class EditorController extends Controller {
    /**
     * editor písniček k zobrazení
     * @param array $parameters parametry v URL
     * @return void
     */
    public function process(array $parameters): void {
        // ověření práv uživatele
        $this->verifyUser(true);
        $songsManager = new SongsManager();
        
        //volání databáze k zobrazení akordů
        $chords = $songsManager->getChords();
        $this->data['chords'] = $chords;
        
        //data do hlavičky stránky
        $this->header = array(
            'title' => 'Vložení písničky',
            'keywords' => 'formulář, vložení, písnička',
            'description' => 'Vložení písničky do naší databáze',
        );
        
        $songParameters = array (
            'song_id' => '',
            'artist' => '',
            'title' => '',
            'lyrics' => '',
            'url' => '',
            'strumming_pattern' => '',
        );
        
        //přidávání a úprava písniček
        if ($_POST) {
            $keys = array('artist', 'title', 'lyrics', 'url', 'strumming_pattern');
            //omezení výběru podle vyplněných polí
            $songParameters = array_intersect_key($_POST, array_flip($keys)); 
            
            if(!empty($_POST['dropdown1']))
                $songsChords[] = array_search($_POST['dropdown1'], $chords) + 1;
            if(!empty($_POST['dropdown2']))
                $songsChords[] = array_search($_POST['dropdown2'], $chords) + 1;
            if(!empty($_POST['dropdown3']))
                $songsChords[] = array_search($_POST['dropdown3'], $chords) + 1;
            if(!empty($_POST['dropdown4']))
                $songsChords[] = array_search($_POST['dropdown4'], $chords) + 1;
            if(!empty($_POST['dropdown5']))
                $songsChords[] = array_search($_POST['dropdown5'], $chords) + 1;
            
            //úprava, pokud již písnička existuje (má ID)
            if ($_POST['song_id']) {
                $songsManager->updateSong($_POST['song_id'], $songParameters);
                $this->addMessage('success', 'Písnička byla změněna');
                $this->reroute('song/' . $songParameters['url']);
            } 
            //vložení nové písničky
            else {
                $songsManager->insertSong($songParameters);
                $songsManager->insertChords($songsChords);
                $this->addMessage('success', 'Písnička byla přidána.');
                $this->reroute('song/' . $songParameters['url']);
            }
        } 
        //načtení písničky k úpravě
        else if (!empty($parameters[0])) {
            $loadedSong = $songsManager->getSong($parameters[0]);
            if ($loadedSong) {
                $songParameters = $loadedSong;
            } else {
                $this->reroute('error');
            }
        }
        
        $this->data['songParameters'] = $songParameters;
        $this->view = 'editor';
    }
}