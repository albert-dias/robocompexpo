import React from 'react';
import { createStackNavigator, TransitionPresets } from '@react-navigation/stack';

import theme from '../global/styles/theme';
import { Intro } from '../Intro';
import { Login } from '../pages/Login';
import { ClientRegister } from '../pages/ClientRegister/Cadastro';
import { EmpresaRegister } from '../pages/EmpresaRegister/Cadastro';
import { SelecionarPerfil } from '../pages/SelecionarPerfil';

const Auth = createStackNavigator();

const AuthRoutes: React.FC = () => (
    <Auth.Navigator
        screenOptions={{
            headerShown: false,
            cardStyle: { backgroundColor: theme.colors.contrast },
            ...TransitionPresets.SlideFromRightIOS,
        }}
    >
        <Auth.Screen name="Intro" component={Intro} />
        <Auth.Screen name="Login" component={Login} />
        <Auth.Screen name="ClientRegister" component={ClientRegister} />
        <Auth.Screen name="EmpresaRegister" component={EmpresaRegister} />
        <Auth.Screen name="SelecionarPerfil" component={SelecionarPerfil}/>

    </Auth.Navigator>
);

export default AuthRoutes;