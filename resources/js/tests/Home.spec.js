import { mount } from '@vue/test-utils';
import Home from '@/components/Home.vue';

describe('Home.vue', () => {
  it('renders correctly', () => {
    const wrapper = mount(Home);
    expect(wrapper.exists()).toBe(true);
  });
});
