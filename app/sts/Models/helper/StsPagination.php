<?php

namespace Sts\Models\helper;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class StsPagination
{
    private $Link;
    private $MaxLink;
    private $Pagina;
    private $LimitResultado;
    private $Offset;
    private $Query;
    private $ParseString;
    private $ResultBd;
    private $Resultado;
    private $TotalPaginas;

    function __construct($Link)
    {
        $this->Link = $Link;
        $this->MaxLink = 2;
    }

    public function getOffset()
    {
        return $this->Offset;
    }

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function condicao($Pagina, $LimitResultado)
    {
        $this->Pagina = (int) $Pagina ? $Pagina :  1;
        $this->LimitResultado = (int) $LimitResultado;
        $this->Offset = ($this->Pagina * $this->LimitResultado) - $this->LimitResultado;
    }
    public function paginacao($Query, $ParseString = null)
    {
        $this->Query = (string) $Query;
        $this->ParseString = (string) $ParseString;
        $contar = new \Sts\Models\helper\StsRead();
        $contar->fullRead($this->Query);
        $this->ResultBd = $contar->getResultado();
        // var_dump($this->ResultBd);
        if ($this->ResultBd[0]['num_result'] > $this->LimitResultado) {
            $this->instrucaoPaginacao();
        } else {
            $this->Resultado = null;
        }
    }
    private function instrucaoPaginacao()
    {
        $this->TotalPaginas = ceil($this->ResultBd[0]['num_result'] / $this->LimitResultado);

        if (!($this->TotalPaginas >= $this->Pagina))
            header("Location:" . $this->Link);

        $this->layoutPaginacao();
    }

    private function layoutPaginacao()
    {
        $this->Resultado = '<nav aria-label="...">';
        $this->Resultado .= '<ul class="pagination">';
        $this->Resultado .= '<li class="page-item">';
        $this->Resultado .= '<a class="page-link" href="' . $this->Link . '">First</a>';
        $this->Resultado .= '</li>';
        for ($iPag = $this->Pagina - $this->MaxLink; $iPag <= $this->Pagina - 1; $iPag++) {
            if ($iPag >= 1) {
                $this->Resultado .= '<li class="page-item"><a class="page-link" href="' . $this->Link . '?pg=' . $iPag . '">' . $iPag . '</a></li>';
            }
        }
        $this->Resultado .= '<li class="page-item active">';
        $this->Resultado .= '<span class="page-link">' . $this->Pagina . '</span>';
        $this->Resultado .= '</span>';
        $this->Resultado .= '</li>';
        for ($dPag = $this->Pagina + 1; $dPag <= $this->Pagina + $this->MaxLink; $dPag++) {
            if ($dPag <=  $this->TotalPaginas) {
                $this->Resultado .= '<li class="page-item"><a class="page-link" href="' . $this->Link . '?pg=' . $dPag . '">' . $dPag . '</a></li>';
            }
        }
        $this->Resultado .= '<li class="page-item">';
        $this->Resultado .= '<a class="page-link" href="' . $this->Link . '?pg=' . $this->TotalPaginas . '">Last</a>';
        $this->Resultado .= '</li>';
        $this->Resultado .= '</ul>';
        $this->Resultado .= '</nav>';
    }
}
