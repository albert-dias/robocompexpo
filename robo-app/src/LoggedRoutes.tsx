import React, { useEffect, useState } from 'react';
import { TouchableWithoutFeedback, View } from 'react-native';
import { useNavigation } from '@react-navigation/native';

import LoggedStackNavigator from './pages/LoggedStackNavigator';
import screenOptions from './pages/screenOptions';
// import GlobalContext from './context';
import Appbar from './components/Appbar';

import { AdmHome } from './pages/AdmHome';
import { AdmMetrics } from './pages/AdmHome/AdmMetrics';

const { Navigator, Screen } = LoggedStackNavigator;

// const {
//     login: { userTypeRef },
// } = GlobalContext;

export function LoggedRoutes() {
    const [open, setOpen] = useState(false);

    const navigation = useNavigation();

    useEffect(() => {
        // navigation.navigate('Home');
    }, []);

    return (
        <>
            <Appbar>
                <Navigator {...{ screenOptions }}>
                        <>
                            <Screen name='Home' component={AdmHome} />
                            <Screen name='AdmMetrics' component={AdmMetrics} />
                        </>
                    )}
                </Navigator>
            </Appbar>
        </>
    );
}