<?php

namespace Couscous\Module\Markdown\Step;

use Couscous\Module\Markdown\Model\MarkdownFile;
use Couscous\Model\Repository;
use Couscous\Step;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Processes links to *.md (markdown) files.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class ProcessMarkdownLinks implements Step
{
    // OMG regexes...
    const MARKDOWN_LINK_REGEX = '#\[([^\]]+)\]\(([^\)]+)\.md\)#';
    const REGEX_REPLACEMENT   = '[$1]($2.html)';

    public function __invoke(Repository $repository, OutputInterface $output)
    {
        /** @var MarkdownFile[] $markdownFiles */
        $markdownFiles = $repository->findFilesByType('Couscous\Module\Markdown\Model\MarkdownFile');

        foreach ($markdownFiles as $file) {
            $file->content = preg_replace(
                self::MARKDOWN_LINK_REGEX,
                self::REGEX_REPLACEMENT,
                $file->content
            );
        }
    }
}
