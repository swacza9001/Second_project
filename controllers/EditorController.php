<?php

class EditorController extends Controller {
    
    public function process(array $parameters): void {
        $this->verifyUser(true);
        $songsManager = new SongsManager();
        $chords = $songsManager->getChords();
        $this->data['chords'] = $chords;
        
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
        
        if ($_POST) {
            $keys = array('artist', 'title', 'lyrics', 'url', 'strumming_pattern');
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
            
            if ($_POST['song_id']) {
                $songsManager->updateSong($_POST['song_id'], $songParameters);
                $this->addMessage('success', 'Písnička byla změněna');
                $this->reroute('song/' . $songParameters['url']);
            } else {
                $songsManager->insertSong($songParameters);
                $songsManager->insertChords($songsChords);
                $this->addMessage('success', 'Písnička byla přidána.');
                $this->reroute('song/' . $songParameters['url']);
            }
        } else if (!empty($parameters[0])) {
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