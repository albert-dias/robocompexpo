// Import de pacotes
import React from 'react';
import { createStackNavigator, TransitionPresets } from '@react-navigation/stack';

// Import de tema
import theme from '../global/styles/theme';

// Páginas que a Empresa/o técnico pode acessar
import { AdmHome } from '../pages/AdmHome';
import { AdmMetrics } from '../pages/AdmHome/AdmMetrics';

const Auth = createStackNavigator();

const AdmRoutes: React.FC = () => (
    <Auth.Navigator
        screenOptions={{
            headerShown: false,
            cardStyle: { backgroundColor: theme.colors.contrast },
            ...TransitionPresets.SlideFromRightIOS,
        }}
    >
        <Auth.Screen name="Home" component={AdmHome} />
        <Auth.Screen name="AdmMetrics" component={AdmMetrics} />
    </Auth.Navigator>
);

export default AdmRoutes;