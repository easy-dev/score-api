<?php
namespace App\Form;

use App\Scores\Sorting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class SortingType extends AbstractType implements DataMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field', TextType::class)
            ->add('order', TextType::class, [
                'constraints' => [
                    new Choice(Sorting::SORT_ORDERS)
                ]
            ])
            ->setDataMapper($this);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'compound' => true,
            'empty_data' => null
        ]);
    }

    /**
     * Returns The block prefix of this type.
     *
     * @return string The block prefix of this type
     */
    public function getBlockPrefix()
    {
        return 'sorting';
    }

    /**
     * Maps properties of some data to a list of forms.
     *
     * @param mixed $data Structured data.
     * @param FormInterface[] $forms A list of {@link FormInterface} instances.
     *
     */
    public function mapDataToForms($data, $forms)
    {
        // not required atm
    }

    /**
     * Maps the data of a list of forms into the properties of some data.
     *
     * @param FormInterface[] $forms A list of {@link FormInterface} instances.
     * @param mixed $data Structured data.
     *
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = new Sorting(
            $forms['field']->getData(),
            $forms['order']->getData(),
        );
    }
}