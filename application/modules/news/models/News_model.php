<?php

class News_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get news entries
     *
     * @param  Int $start
     * @param  Int $limit
     * @return Array
     */
    public function getArticles($start = 0, $limit = 1)
    {
        if ($start === true) {
            $this->db->select('*');
        } else {
            $this->db->select('*');
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('articles');
        $result = $query->result_array();

        // Did we have any results?
        if ($result) {
            return $this->template->format($result);
        } else {
            // Instead of showing a blank space, we show a default article
            $default_lang = $this->language->getAbbreviationByLanguage($this->language->getDefaultLanguage());
            return array(
                        array(
                            'id'                             => 0,
                            'headline_' . $default_lang . '' => 'Welcome to FusionGEN V2!',
                            'content_' . $default_lang . ''  => 'Welcome to your new website! This news article will disappear as soon as you add a new one.',
                            'author_id'                      => 0,
                            'timestamp'                      => time(),
                            'type'                           => 0,
                            'type_content'                   => null,
                            'comments'                       => -1,
                            'headline_de'                    => 'Willkommen bei FusionGEN V2!',
                            'content_de'                     => 'Willkommen auf Ihrer neuen Webseite! Dieser Nachrichtenartikel wird verschwinden, sobald Sie einen neuen hinzufügen.',
                            'headline_es'                    => '¡Bienvenido a FusionGEN V2!',
                            'content_es'                     => '¡Bienvenido a tu nueva página web! Esta noticia desaparecerá tan pronto como añadas una nueva.',
                            'headline_fr'                    => 'Bienvenue sur FusionGEN V2!',
                            'content_fr'                     => 'Bienvenue sur votre nouveau site web! Cet article de presse disparaîtra dès que vous en ajouterez un nouveau.',
                            'headline_no'                    => 'Velkommen til FusionGEN V2!',
                            'content_no'                     => 'Velkommen til din nye nettside! Denne nyhetsartikkelen forsvinner så snart du legger til en ny.',
                            'headline_ro'                    => 'Bun venit la FusionGEN V2!',
                            'content_ro'                     => 'Bun venit pe noul dumneavoastră site web! Acest articol de știri va dispărea de îndată ce veți adăuga unul nou.',
                            'headline_se'                    => 'Välkommen till FusionGEN V2!',
                            'content_se'                     => 'Välkommen till din nya webbplats! Denna nyhetsartikel försvinner så snart du lägger till en ny.',
                            'headline_ru'                    => 'Добро пожаловать в FusionGEN V2!',
                            'content_ru'                     => 'Добро пожаловать на ваш новый сайт! Эта новостная статья исчезнет, как только вы добавите новую.',
                            'headline_zh'                    => '欢迎来到 FusionGEN V2!',
                            'content_zh'                     => '欢迎来到您的新网站！一旦您添加新文章，此新闻文章就会消失。',
                            'headline_ko'                    => 'FusionGEN V2에 오신 것을 환영합니다!',
                            'content_ko'                     => '새로운 웹사이트에 오신 것을 환영합니다! 새 기사를 추가하면 이 뉴스 기사는 사라집니다.'
                        )
                    );
        }
    }

    /**
     * Get the article with the specified id.
     *
     * @param  $id
     * @return bool
     */
    public function getArticle($id)
    {
        $query = $this->db->query("SELECT * FROM articles WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Get the tags for the given article id
     *
     * @param  $articleId
     * @return array|bool
     */
    public function getTags($articleId)
    {
        $this->db->select('t.name');
        $this->db->where('at.article_id', $articleId);
        $this->db->where('at.tag_id = t.id');
        $query = $this->db->get('tag t, article_tag at');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Count the articles
     *
     * @return Int
     */
    public function countArticles()
    {
        return $this->db->count_all('articles');
    }

    /**
     * Check whether an article exists or not
     *
     * @param  Int $id
     * @param  Boolean $comment Check if comments are enabled
     * @return bool
     */
    public function articleExists($id, $comment = false)
    {
        if (!$id) {
            return false;
        }

        $this->db->select('comments');
        $this->db->where('id', $id);
        $query = $this->db->get('articles');

        $result = $query->result_array();

        // If comments are enabled
        if ($comment && count($result) && $result[0]['comments'] != -1) {
            return true;
        }
        // If article exists
        elseif (!$comment && count($result)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create a news article
     *
     * @param  $headline
     * @param  $comments
     * @param  $content
     * @return bool
     */
    public function create($type, $type_content, $comments, $headline_en, $content_en, $headline_de, $content_de, $headline_es, $content_es, $headline_fr, $content_fr, $headline_no, $content_no, $headline_ro, $content_ro, $headline_se, $content_se, $headline_ru, $content_ru, $headline_zh, $content_zh, $headline_ko, $content_ko)
    {
        $data = array(
            'type' => $type,
            'type_content' => $type_content,
            'comments' => $comments,
            'timestamp' => time(),
            'author_id' => $this->user->getId(),
            'headline_en'  => $headline_en,
            'content_en'   => $content_en,
            'headline_de'  => $headline_de,
            'content_de'   => $content_de,
            'headline_es'  => $headline_es,
            'content_es'   => $content_es,
            'headline_fr'  => $headline_fr,
            'content_fr'   => $content_fr,
            'headline_no'  => $headline_no,
            'content_no'   => $content_no,
            'headline_ro'  => $headline_ro,
            'content_ro'   => $content_ro,
            'headline_se'  => $headline_se,
            'content_se'   => $content_se,
            'headline_ru'  => $headline_ru,
            'content_ru'   => $content_ru,
            'headline_zh'  => $headline_zh,
            'content_zh'   => $content_zh,
            'headline_ko'  => $headline_ko,
            'content_ko'   => $content_ko,
        );

        $this->db->insert("articles", $data);

        return true;
    }

    /**
     * Update the article with the given id
     *
     * @param  $id
     * @param  $headline
     * @param  $comments
     * @param  $content
     * @return bool
     */
    public function update($id, $type, $type_content, $comments, $headline_en, $content_en, $headline_de, $content_de, $headline_es, $content_es, $headline_fr, $content_fr, $headline_no, $content_no, $headline_ro, $content_ro, $headline_se, $content_se, $headline_ru, $content_ru, $headline_zh, $content_zh, $headline_ko, $content_ko)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $data = array(
            'type'         => $type,
            'type_content' => $type_content,
            'comments'     => $comments,
            'headline_en'  => $headline_en,
            'content_en'   => $content_en,
            'headline_de'  => $headline_de,
            'content_de'   => $content_de,
            'headline_es'  => $headline_es,
            'content_es'   => $content_es,
            'headline_fr'  => $headline_fr,
            'content_fr'   => $content_fr,
            'headline_no'  => $headline_no,
            'content_no'   => $content_no,
            'headline_ro'  => $headline_ro,
            'content_ro'   => $content_ro,
            'headline_se'  => $headline_se,
            'content_se'   => $content_se,
            'headline_ru'  => $headline_ru,
            'content_ru'   => $content_ru,
            'headline_zh'  => $headline_zh,
            'content_zh'   => $content_zh,
            'headline_ko'  => $headline_ko,
            'content_ko'   => $content_ko,
        );

        if ($data['comments'] == 0) {
            $query = $this->db->query("SELECT COUNT(*) as `total` FROM comments WHERE article_id=?", array($id));
            $result = $query->result_array();

            if ($result[0]['total'] != 0) {
                $data['comments'] = $result[0]['total'];
            }
        }

        $this->db->where('id', $id);
        $this->db->update("articles", $data);

        return true;
    }

    /**
     * Delete the article with the given id.
     *
     * @param  $articleId
     * @return bool
     */
    public function delete($articleId)
    {
        if (!is_numeric($articleId)) {
            return false;
        }

        $this->db->where('id', $articleId);
        $this->db->delete('articles');

        return true;
    }
}
