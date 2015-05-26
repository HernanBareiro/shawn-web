#ifndef __SHAWN_APPS_SIMPLE_APP_INIT_H
#define __SHAWN_APPS_SIMPLE_APP_INIT_H

#include "_legacyapps_enable_cmake.h"
#ifdef ENABLE_SIMPLE_APP

namespace shawn
{ class SimulationController; }


extern "C" void init_simple_app( shawn::SimulationController& );


#endif
#endif
