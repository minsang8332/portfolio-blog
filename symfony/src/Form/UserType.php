<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author yuu2dev
 * updated 2020.06.10
 */
class UserType extends AbstractType {
  
  /**
   * @var TranslatorInterface
   */
  private $translator;

  /**
   * @access public
   * @param TranslatorInterface $translator
   */
  public function __construct(TranslatorInterface $translator) {
    $this->translator = $translator;
  }
  
  /**
   * @access public
   * @param FormBuilderInterface $builder
   * @param array $options
   * @return void
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    
    $translator = $this->translator;

    $builder
      // 이메일
      ->add('email', EmailType::class, array(
        'label' => $translator->trans('front.member.register.email'),
        'required' => true,
      ))

      // 패스워드
      ->add('password', RepeatedType::class, array(
        'type' => PasswordType::class,
        'invalid_message' => $translator->trans('front.member.register.password.invalid'),
        'first_options'  => array(
          'help' => $translator->trans('front.member.register.password.help'),
          'label' => $translator->trans('front.member.register.password'),
          'constraints' => $this->getPasswordConstraints()
        ),
        'second_options' => array(
          'help' => $translator->trans('front.member.register.password.confirm.help'),
          'label' => $translator->trans('front.member.register.password.confirm'),
          'constraints' => $this->getPasswordConstraints() 
        ),
        'required' => true,
      ))

      // 닉네임
      ->add('alias', TextType::class, array(
        'label' => $translator->trans('front.member.register.alias'),
        'required' => true
      ))

      // 썸네일
      ->add('thumbnail', FileType::class, array(
        'constraints' => array(
          new File(array(
              'maxSize' => '5120k',
              'mimeTypes' => array(
                'image/png',
                'image/jpg',
                'image/jpeg'
              ),
          ))
        ),
        'help' => $translator->trans('front.member.register.thumbnail.help'),
        'required' => false,
      ))

      // 전송
      ->add('submit', SubmitType::class, array(
        'label' => $translator->trans('front.member.register.submit')
      ));
    ;
  }

  /**
   * 패스워드 유효성 검사
   * @see 중복코드제거
   * @access public
   * @return array
   */
  public function getPasswordConstraints(): ?array {
    return array(
      new Assert\Length(array(
        'min'        => 8,
        'max'        => 20,
        'minMessage' => 'assert.member.password.length.min',
        'maxMessage' => 'assert.member.password.length.max'
      )),
      new Assert\Regex(array(
        'pattern' => '/^[\w]{8, 20}$/',
        'match'   => false,
        'message' => 'assert.member.password.regex'
      )),
    );
  }

  /**
   * @access public
   * @param OptionResolver $resolver
   * @return void
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'csrf_protection' => true,
      'data_class' => User::class
    ]);
  }
}
