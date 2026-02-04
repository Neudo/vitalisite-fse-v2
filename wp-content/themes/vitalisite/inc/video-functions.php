<?php
/**
 * Fonctions pour le widget vidéo médicale
 */

if (!function_exists('vitalisite_get_video_info')) {
    /**
     * Extrait les informations d'une vidéo YouTube ou Vimeo
     */
    function vitalisite_get_video_info($url) {
        $info = [
            'platform' => '',
            'video_id' => '',
            'embed_url' => '',
            'thumbnail_url' => '',
            'title' => '',
        ];

        if (empty($url)) {
            return $info;
        }

        // YouTube
        if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
            $info['platform'] = 'youtube';
            
            // Extraire l'ID YouTube
            if (preg_match('/youtube\.com.*v=([^&]+)/', $url, $matches)) {
                $info['video_id'] = $matches[1];
            } elseif (preg_match('/youtu\.be\/([^?]+)/', $url, $matches)) {
                $info['video_id'] = $matches[1];
            }
            
            if (!empty($info['video_id'])) {
                $info['embed_url'] = "https://www.youtube.com/embed/" . $info['video_id'];
                $info['thumbnail_url'] = "https://img.youtube.com/vi/" . $info['video_id'] . "/maxresdefault.jpg";
            }
        }
        
        // Vimeo
        elseif (strpos($url, 'vimeo.com') !== false) {
            $info['platform'] = 'vimeo';
            
            // Extraire l'ID Vimeo
            if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
                $info['video_id'] = $matches[1];
            }
            
            if (!empty($info['video_id'])) {
                $info['embed_url'] = "https://player.vimeo.com/video/" . $info['video_id'];
                // Pour Vimeo, il faut faire une requête API pour obtenir la miniature
                $info['thumbnail_url'] = "https://vimeo.com/api/v2/video/" . $info['video_id'] . ".json";
            }
        }

        return $info;
    }
}

if (!function_exists('vitalisite_get_vimeo_thumbnail')) {
    /**
     * Récupère la miniature Vimeo via l'API
     */
    function vitalisite_get_vimeo_thumbnail($video_id) {
        $response = wp_remote_get("https://vimeo.com/api/v2/video/" . $video_id . ".json");
        
        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            
            if (!empty($data[0]['thumbnail_large'])) {
                return $data[0]['thumbnail_large'];
            }
        }
        
        return ''; // Retourner vide si échec
    }
}

if (!function_exists('vitalisite_build_embed_params')) {
    /**
     * Construit les paramètres d'embed pour la vidéo
     */
    function vitalisite_build_embed_params($autoplay = false) {
        $params = [];
        
        if ($autoplay) {
            $params['autoplay'] = '1';
            $params['mute'] = '1'; // YouTube requiert le mode muet pour autoplay
        }
        
        // Paramètres communs pour une meilleure expérience
        $params['rel'] = '0'; // Ne pas montrer les vidéos similaires
        $params['showinfo'] = '0'; // Ne pas montrer les infos
        $params['modestbranding'] = '1'; // Branding discret
        
        return !empty($params) ? '?' . http_build_query($params) : '';
    }
}
