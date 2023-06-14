import { mount } from '@vue/test-utils';
import Card from '@/components/Card.vue';

describe('Card.vue', () => {
  it('displays correct title and number', () => {
    const title = 'Total';
    const number = '123';
    const wrapper = mount(Card, {
      props: {
        title,
        number,
        bgColor: 'bg-info',
        col: '6',
      },
    });
    expect(wrapper.text()).toContain(title);
    expect(wrapper.text()).toContain(number);
  });
});
