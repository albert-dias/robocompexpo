import {
    createStackNavigator,
    StackNavigationProp
} from "@react-navigation/stack";
import { CompositeNavigationProp } from "@react-navigation/native";
import { RootAppStackParamList } from './AppStackNavigator';

type RootLoggedStackParamListUndefinedRoutes =
    | 'AdmHome'
    | 'Agenda'
    | 'ClientRegister'
    | 'EditPassword'
    | 'EditProfile'
    | 'EmpresaTIHome'
    | 'Home'
    | 'InOrder'
    | 'InProgress'
    | 'Plans'
    | 'Profile'
    | 'Services'
    | 'ShoppingCart'
    | 'UserTerms';

export type RootLoggedStackParamList = {
    [s in RootLoggedStackParamListUndefinedRoutes]: undefined
};

export type FCWithLoggedStackNavigator<
    T extends keyof RootLoggedStackParamList
    > = React.FC<{
        navigation: CompositeNavigationProp<
            StackNavigationProp<RootLoggedStackParamList, T>,
            StackNavigationProp<RootAppStackParamList>
        >;
    }>;

const LoggedStackNavigator = createStackNavigator<RootLoggedStackParamList>();

export default LoggedStackNavigator;