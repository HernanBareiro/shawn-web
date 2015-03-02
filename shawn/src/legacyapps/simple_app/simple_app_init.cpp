#include "legacyapps/simple_app/simple_app_init.h"
#ifdef ENABLE_SIMPLE_APP

#include "legacyapps/simple_app/simple_app_processor_factory.h"

extern "C" void init_simple_app( shawn::SimulationController& sc )
{
   simple_app::SimpleAppProcessorFactory::register_factory( sc );
}

#endif
