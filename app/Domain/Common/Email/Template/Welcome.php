<?php

declare(strict_types=1);

namespace App\Domain\Common\Email\Template;

use App\Domain\Common\Email\Email;
use App\Domain\Common\Email\EmailAddress;
use App\Domain\Common\Email\EmailRenderer;
use App\Domain\User\User;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Application;

final readonly class Welcome
{
    private PasswordBroker $passwordBroker;

    public function __construct(
        private Translator $translator,
        private EmailRenderer $emailRenderer,
        private UrlGenerator $urlGenerator,
        private ConfigRepository $configRepository,
        Application $app,
    ) {
        $this->passwordBroker = $app->get('auth.password.broker.new_users');
    }

    public function create(User $user): Email
    {
        $currentLocale = $this->translator->getLocale();
        $this->translator->setLocale($user->language);

        $fromEmail = $this->configRepository->get('mail.from');

        $email = new Email(
            EmailAddress::fromEmail($user->email),
            EmailAddress::fromEmailAndName($fromEmail['address'], $this->translator->get('email.from')),
            $this->emailRenderer->renderWithMarkdown('emails.welcome-create-password', [
                'name' => $user->name,
                'url' => $this->getCreatePasswordPageUrl($user),
            ]),
            $this->translator->get('email.welcome_external_user.subject')
        );
        $this->translator->setLocale($currentLocale);

        return $email;
    }

    private function getCreatePasswordPageUrl(User $user): string
    {
        $token = $this->passwordBroker->createToken($user);
        $email = http_build_query(['email' => $user->email]);

        return $this->urlGenerator->to("/app/password/create/{$token}?{$email}");
    }
}
