import { createStackNavigator, StackNavigationProp } from '@react-navigation/stack';

type RootAppStackParamListUndefinedRoutes = 'Login'
| 'ClientRegister'
| 'EmpresaRegister';

export type RootAppStackParamList = {
  [s in RootAppStackParamListUndefinedRoutes]: undefined
};

export type FCWithAppStackNavigator<T extends keyof RootAppStackParamList> = React.FC<{
  navigation: StackNavigationProp<RootAppStackParamList, T>;
}>;

const AppStackNavigator = createStackNavigator<RootAppStackParamList>();

export default AppStackNavigator;
