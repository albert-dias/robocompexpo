// Import de pacotes
import React from 'react';
import { Image, StyleSheet, Text, TouchableOpacity } from 'react-native';
import { FontAwesome5 } from '@expo/vector-icons';

// Import de páginas
import Container from '../../components/Container';
import theme from '../../global/styles/theme';

// Import de imagens
import Robo404 from '../../../assets/images/not_found.png';

export function InOrder() {
    return (
        <Container style={styles.container}>
            <TouchableOpacity
                onPress={() => console.log('navigate(Home)')}
                style={{
                    position: 'absolute',
                    alignSelf: 'flex-start',
                    marginLeft: '4%',
                    marginTop: '8%',
                    alignContent: 'flex-start',
                    alignItems: 'flex-start',
                }}>
                <FontAwesome5 name='chevron-left' color={theme.colors.black} size={40} />
            </TouchableOpacity>
            <Image source={Robo404} style={styles.image} />
            <Text style={styles.text}>Ops :(</Text>
            <Text></Text>
            <Text style={styles.text}>
                Essa tela do Robocomp
            </Text>
            <Text style={styles.text}>ainda está em construção.</Text>
        </Container>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection: 'column',
        backgroundColor: '#ccc',
    },
    image: {
        width: 280,
        height: 285,
        alignSelf: 'center',
        marginTop: '40%',
        marginBottom: 25,
    },
    text: {
        alignContent: 'center',
        textAlign: 'center',
        fontSize: 14,
    },
});