<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Str;

class SlugService
{
    /**
     * Gera um slug único para um link de um usuário.
     *
     * O slug é baseado no nome informado e garantido como único
     * por usuário. Caso já exista, um sufixo numérico incremental
     * será adicionado (-2, -3, ...).
     * @param int    $userId ID do usuário dono do link
     * @param string $name   Nome do link informado pelo usuário
     *
     * @return string Slug gerado e pronto para uso
     */
    public function generateForUserLink(int $userId, string $name): string
    {
        $base = Str::slug($name);

        $slugs = Link::where('user_id', $userId)
            ->where('slug', 'LIKE', $base . '%')
            ->pluck('slug');

        if ($slugs->isEmpty()) return $base;

        $max = $slugs->map(function ($slug) use ($base) {
                if ($slug === $base) return 1;
                if (str_starts_with($slug, $base . '-')) {
                    return (int) substr($slug, strlen($base) + 1);
                }
                return 0;
            })
            ->max();

        return $max >= 2 ? "{$base}-" . ($max + 1) : "{$base}-2";
    }
}
